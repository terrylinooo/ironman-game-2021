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

<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
    <li>
	    <?php esc_html_e( 'Bank code:', 'wc-sinopac-payment' ); ?>
		<strong>807</strong>
	</li>
	<li>
		<?php esc_html_e( 'Virtual bank account:', 'wc-sinopac-payment' ); ?>
		<strong><?php echo $atm_no;  ?></strong>
	</li>
</ul>