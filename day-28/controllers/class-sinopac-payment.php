<?php
/*
 * This file is part of the WooCommerce SinoPac Payment package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined( 'WCSP_INC' ) || exit;

class SinoPac_Payment {

	/**
	 * Receive data (POST method) after making credit card payment.
	 *
	 * @var string
	 */
	public $return_endpoint = 'sinopac/message_receive';

	/**
	 * Receive the successful result after cusomter pay with virtual account. 
	 *
	 * @var string
	 */
	public $backend_endpoint = 'sinopac/backend_notify';

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'plugins_loaded', array( $this, 'load_payment_class' ) );
		add_filter( 'woocommerce_payment_gateways', array( $this, 'add_payment_gateway' ) );

		add_action( 'template_redirect', array( $this, 'do_message_receive' ), 0 );
		add_action( 'template_redirect', array( $this, 'do_backend_notify' ), 1 );

		add_action( 'woocommerce_thankyou', array( $this, 'display_transation_info' ), 10, 1 );
		add_action( 'woocommerce_after_order_details', array( $this, 'display_payment_info_for_va' ), 10, 1 );
	}

	/**
	 *	Load required payment method classes.
	 * 
	 * @return void
	 */
	public function load_payment_class() {
		$files = array(
			'cc',
			'va',
		);

		foreach ( $files as $file ) {
			$file = __DIR__ . '/../includes/class-wc-gateway-sinopac-' . $file . '.php';

			if ( file_exists( $file ) ) {
				include $file;
			}
		}
	}

	/**
	 * Load gateways and hook in functions.
	 * 
	 * @param array $methods Payment methods.
	 *
	 * @return array
	 */
	public function add_payment_gateway( $methods ) {
		$methods['sinopac-cc'] = 'WC_SinoPac_Credit_Card_Payment';
		$methods['sinopac-va'] = 'WC_SinoPac_Virtual_Account_Payment';
		return $methods;
	}

	/**
	 * Do things when receiving message from SinoPac platform.
	 * 
	 * @param bool $is_backend 
	 *
	 * @return void
	 */
	public function do_message_receive( $is_backend = false ) {
		global $wp;

		if (
			0 === stripos( $wp->request, $this->return_endpoint ) || 
			$is_backend
		) {
			$success = false;
			$order   = null;

			$return_shop_no   = isset( $_POST['ShopNo'] ) ? sanitize_text_field( $_POST['ShopNo'] ) : '';
			$return_pay_token = isset( $_POST['PayToken'] ) ? sanitize_text_field( $_POST['PayToken'] ) : '';

			if ( $is_backend ) {
				$gateway = new WC_SinoPac_Virtual_Account_Payment();
			} else {
				$gateway = new WC_SinoPac_Credit_Card_Payment();
			}
			
			$sandbox = $gateway->testmode === 'yes' ? true : false;

			if ( $sandbox ) {
				$shop_no = $gateway->test_shop_no ?? '';
			} else {
				$shop_no = $gateway->api_shop_no ?? '';
			}

			if ( $shop_no === $return_shop_no && '' !== $return_pay_token ) {
				$qpay    = wcsp_get_qpay_instance( $gateway );
				$results = $qpay->queryOrderByToken( $return_pay_token );
		
				if ( ! empty( $results['Message'] ) ) {
					if ( 'S' === $results['Message']['Status'] ) {
						$transaction    = $results['Message']['TSResultContent'];
						$order_id       = $transaction['OrderNo'];
						$transaction_no = $transaction['TSNo'];
						$pay_type       = $transaction['PayType'];
						$pay_date       = wp_date( 'Y/m/d H:i', strtotime( $transaction['PayDate'] ) );
						$amount         = $transaction['Amount'] / 100;

						$pay_type_text  = $pay_type === 'C' 
							? __( 'Credit Card', 'wc-sinopac-payment' )
							: __( 'Virtual Account', 'wc-sinopac-payment' );

						$order = wc_get_order( $order_id );

						if ( $order ) {

							$meta = $order->get_meta( wcsp_get_sinopac_meta_key() );

							if ( empty( $meta ) ) {
								$transation_log = array(
									'pay_token'     => $return_pay_token,
									'type'          => $pay_type,
									'transation_no' => $transaction_no,
									'return_data'   => $transaction,
								);
							} else {
								$meta['pay_token']     = $return_pay_token;
								$meta['type']          = $pay_type;
								$meta['transation_no'] = $transaction_no;
								$meta['return_data']   = $transaction;

								$transation_log = $meta;
							}

							$message = '';
	
							if ( $is_backend ) {
								$message .= __( 'Received notification from SinoPac:', 'wc-sinopac-payment' ) . "\n";
								$message .= __( 'The customer has paid for this order successfully.', 'wc-sinopac-payment' ) . "\n";
							}
	
							$message .= __( 'Transation is completed.', 'wc-sinopac-payment' ) . "\n";
							$message .= __( 'Transation No', 'wc-sinopac-payment' ) . ': ' . $transaction_no . "\n";
							$message .= __( 'Payment type') . ': ' . $pay_type_text . "\n";
							$message .= __( 'Paid date', 'wc-sinopac-payment' ) . ': ' . $pay_date . "\n";
							$message .= __( 'Paid amount', 'wc-sinopac-payment' ) . ': ' . $amount . "\n";

							$order->add_order_note( $message );
							$order->update_status( 'processing' );
							$order->update_meta_data( wcsp_get_sinopac_meta_key(), $transation_log );
							$order->save();

							$success = true;
						}
					} else {
						error_log( json_encode( $results, JSON_PRETTY_PRINT ) );
					}
				}
			}

			if ( $success && $order ) {
				wp_redirect( $gateway->get_return_url( $order ) );
				exit;
			} else {
				wp_die( __( 'Something went wrong.', 'wc-sinopac-payment' ) );
			}
		}
	}

	/**
	 * Do things when SinoPac platform notifying us about the payment results.
	 *
	 * @return void
	 */
	public function do_backend_notify() {
		global $wp;

		if ( 0 === stripos( $wp->request, $this->backend_endpoint ) ) {
			$this->do_message_receive( true );
		}
	}

	/**
	 * Display payment information for virtual account.
	 *
	 * @param WC_Order $order The order instance
	 *
	 * @return void
	 */
	public function display_payment_info_for_va( $order ) {
		$payment_method = $order->get_payment_method();

		if ( 'sinopac-va' === $payment_method ) {
			$transation_data = $order->get_meta( wcsp_get_sinopac_meta_key() );

			if ( 
				'A' === $transation_data['type'] && 
				! empty( $transation_data['atm_data'] )
			) {
			
				$expired_time = strtotime( $order->get_date_created() ) + 86400 * 7;
				$expired_date = wp_date( 'Y-m-d H:i', $expired_time );
				$data         = $transation_data['atm_data'];

				$data['expired_date'] = $expired_date;

				wcsp_template_render( 'order_detail', $data );
			}
		}
	}

	/**
	 * Display transation infomation if exists.
	 *
	 * @param int $order_id The order ID
	 *
	 * @return void
	 */
	public function display_transation_info( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( $order ) {
			$transation_data = $order->get_meta( wcsp_get_sinopac_meta_key() );
			
			if ( 
				'A' === $transation_data['type'] && 
				! empty( $transation_data['atm_data'] )
			) {
				wcsp_template_render( 'order_received', $transation_data['atm_data'] );
			}
		}
	}
}
