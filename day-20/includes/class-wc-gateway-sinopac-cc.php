<?php
/*
 * This file is part of the WooCommerce SinoPac Payment package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * SinoPac Credit Card Payment (永豐金流信用卡付款方式)
 */
class WC_SinoPac_Credit_Card_Payment extends WC_Payment_Gateway {

	/**
	 * Constructor for the gateway.
	 */
	public function __construct() {

		$this->id                 = 'sinopac-cc';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = __( 'SinoPac QPay: credit card', 'wc-sinopac-payment' );
		$this->method_description = __( 'Have your customers pay with credit card.', 'wc-sinopac-payment' );

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
	
		$this->form_fields = include __DIR__ . '/settings-cc-payment.php';

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

		$order = wc_get_order( $order_id );

        // Reduce stock levels for all line items in the order.
		wc_reduce_stock_levels( $order_id );

		// Remove cart.
		WC()->cart->empty_cart();

		// Return thankyou redirect.
		return array(
			'result'   => 'success',
			'redirect' => $this->get_return_url( $order ),
		);
	}
}
