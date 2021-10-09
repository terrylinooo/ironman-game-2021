<?php
/*
 * This file is part of the WooCommerce SinoPac Payment package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sinopac\QPay;

/**
 * Initialize SinoPac QPay instance.
 * 
 * @param stdClass Payment Gateway
 * 
 * @return QPay
 */
function get_qpay_instance($gateway): QPay
{
    static $instance;

    if (!$instance) {

        $shop_no = $gateway->api_shop_no  ?? '';
        $sandbox = false;

        $hash_group = array(
            $gateway->api_hash_a1 ?? '',
            $gateway->api_hash_a2 ?? '',
            $gateway->api_hash_b1 ?? '',
            $gateway->api_hash_b2 ?? '',
        );
    
        if ( $gateway->testmode === 'yes' ) {
            $shop_no = $gateway->test_shop_no;
            $sandbox = true;
    
            $hash_group = array(
                $gateway->test_hash_a1 ?? '',
                $gateway->test_hash_a2 ?? '',
                $gateway->test_hash_b1 ?? '',
                $gateway->test_hash_b2 ?? '',
            );
        }

        $instance = new QPay([
            'shop_no' => $shop_no,
            'hash'    => $hash_group,
        ]);

        if ($sandbox) {
            $instance->enableSandbox();
        }
    }

    return $instance;
}