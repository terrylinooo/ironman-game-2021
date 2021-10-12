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

?>

<section class="woocommerce-order-details">

	<h3><?php esc_html_e( 'Bank transfer', 'woocommerce' ); ?></h3>

	<ul>
		<li>
			<?php esc_html_e( 'Bank code:', 'wc-sinopac-payment' ); ?>
			<strong>807</strong>
		</li>
		<li>
			<?php esc_html_e( 'Virtual bank account:', 'wc-sinopac-payment' ); ?>
			<strong><?php esc_html_e( $atm_no );  ?></strong>
		</li>
		<li>
			<?php esc_html_e( 'Expires:', 'wc-sinopac-payment' ); ?>
			<strong><?php esc_html_e( $expired_date );  ?></strong>
		</li>
	</ul>

	<p>
		<?php esc_html_e( 'Please pay with bank transfter to above account before it get expired.', 'woocommerce' ); ?>
	</p>
</section>