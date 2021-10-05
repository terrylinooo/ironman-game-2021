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
	 * Initialize.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'plugins_loaded', array( $this, 'load_payment_class' ) );
		add_filter( 'woocommerce_payment_gateways', array( $this, 'add_payment_gateway' ) );
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
	 * @return array
	 */
	public function add_payment_gateway( $methods ) {
		$methods['sinopac-cc'] = 'WC_SinoPac_Credit_Card_Payment';
		return $methods;
	}
}
