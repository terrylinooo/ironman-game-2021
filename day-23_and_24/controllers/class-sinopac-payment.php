<?php
/*
 * This file is part of the WooCommerce SinoPac Payment package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
	}

	/**
	 *	Load required payment method classes.
	 * 
	 * @return void
	 */
	public function load_payment_class() {
		$file = __DIR__ . '/../includes/class-wc-gateway-sinopac-cc.php';

		if ( file_exists( $file ) ) {
			include $file;
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
		return $methods;
	}

	/**
	 * Do things when receiving message from SinoPac platform.
	 *
	 * @return void
	 */
	public function do_message_receive() {
		global $wp;

		if ( 0 === stripos( $wp->request, $this->return_endpoint ) ) {
			$success = false;
			$order   = null;

			$return_shop_no   = $_POST['ShopNo'] ?? '';
			$return_pay_token = $_POST['PayToken'] ?? '';

			$gateway = new WC_SinoPac_Credit_Card_Payment();
			$sandbox = $gateway->testmode === 'yes' ? true : false;

			if ( $sandbox ) {
				$shop_no = $gateway->test_shop_no ?? '';
			} else {
				$shop_no = $gateway->api_shop_no ?? '';
			}

			if ( $shop_no === $return_shop_no && '' !== $return_pay_token ) {
				$qpay    = get_qpay_instance( $gateway );
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

						$transation_log = array(
							'pay_token'     => $return_pay_token,
							'type'          => $pay_type,
							'transation_no' => $transaction_no,
							'return_data'   => $transaction,
						);

						$message  = __( 'Transation is completed.', 'wc-sinopac-payment' ) . "\n";
						$message .= __( 'Transation No', 'wc-sinopac-payment' ) . ': ' . $transaction_no . "\n";
						$message .= __( 'Payment type') . ': ' . $pay_type_text . "\n";
						$message .= __( 'Paid date', 'wc-sinopac-payment' ) . ': ' . $pay_date . "\n";
						$message .= __( 'Paid amount', 'wc-sinopac-payment' ) . ': ' . $amount . "\n";

						if ( $order ) {
							$order->add_order_note( $message );
							$order->update_status( 'processing' );
							$order->update_meta_data( 'payment_log_sinopac', $transation_log );
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

		if ( 0 === stripos( $wp->request, $this->return_endpoint ) ) {

		}
	}
}
