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

use Sinopac\Exception\QPayException;

/**
 * SinoPac Virtual Account Payment (永豐金流虛擬帳號付款方式)
 */
class WC_SinoPac_Virtual_Account_Payment extends WC_Payment_Gateway {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {

		$this->id                 = 'sinopac-va';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = __( 'SinoPac QPay: virtual account', 'wc-sinopac-payment' );
		$this->method_description = __( 'Have your customers pay with bank transfer to a virtual account.', 'wc-sinopac-payment' );

        $this->init();
	}

    /**
     * Initialize settings.
     *
     * @return void
     */
    function init() {

        $this->init_form_fields();
        $this->init_settings();

        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    }

    /**
	 * Initialise Gateway Settings Form Fields.
     *
     * @return void
     */
	function init_form_fields() {
	
		$this->form_fields = include __DIR__ . '/settings-va-payment.php';

        foreach ( $this->form_fields as $key => $value ) {
            $option = $this->get_option( $key );

            if ( '' !== $option ) {
                $this->{$key} = $this->get_option( $key );
            }
        }
	}

	/**
	 * Process the payment and return the result.
	 *
	 * @param int $order_id Order ID.
     *
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$qpay  = wcsp_get_qpay_instance( $this );

		$order = wc_get_order( $order_id );

		foreach ( $order->get_items() as $item ) {
			$product_names[] = $item['name'];
		}

		$api_data = [
			'order_no'         => (string) $order->get_id(),
			'amount'           => $order->get_total() * 100,
			'atm_expired_date' => date( 'Ymd', strtotime( '+7 Days') ),
			'product_name'     => $product_names[0],
			'return_url'       => get_site_url( null, 'sinopac/message_receive' ),
			'backend_url'      => get_site_url( null, 'sinopac/backend_notify' ),
		];

		try {
            $results = $qpay->createOrderByATM( $api_data );
            $message = $this->parse_message( $results );

        } catch ( QPayException $e ) {
			throw new QPayException( $e->getMessage() );
        }

		if ( $message['success'] ) {

			WC()->cart->empty_cart();

			$transation_log = array(
				'pay_token'     => '',
				'type'          => 'A',
				'transation_no' => $results['TSNo'],
				'return_data'   => array(),
				'atm_data'      => $message['atm_data'],
			);

			update_post_meta( $order->get_id(), wcsp_get_sinopac_meta_key(), $transation_log );

			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order ),
			);
		}

		error_log( json_encode( $results, JSON_PRETTY_PRINT ) );

		return array(
			'result'   => 'failed',
			'redirect' => wc_get_checkout_url(),
		);
	}

	/**
	 * Parse the SinoPac API response.
	 *
	 * @param array $results
	 *
	 * @return array
	 */
	private function parse_message( $results )
	{
		$success  = false;
		$atm_data = array();
	
		if ( ! empty( $results['Message'] ) ) {
			$success = ( 'S' === $results['Message']['Status'] );

			if ( $success ) {
				if ( 'A' === $results['Message']['PayType'] ) {
					$atm_data = array(
						'atm_no'  => $results['Message']['ATMParam']['AtmPayNo']  ?? '',
						'atm_url' => $results['Message']['ATMParam']['WebAtmURL'] ?? '',
						'opt_url' => $results['Message']['ATMParam']['OtpURL']    ?? '',
					);
				}
			} else {
				throw new QPayException( $results['Message']['Description'] );
			}
		}

		return array(
			'success'  => $success,
			'atm_data' => $atm_data,
		);
	}
}
