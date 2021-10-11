<?php

$settings = array(

    'enabled' => array(
        'title'   => __( 'Enable/Disable', 'wc-sinopac-payment' ),
        'type'    => 'checkbox',
        'label'   => __( 'Enable Credit Card Payment', 'wc-sinopac-payment' ),
        'default' => 'no',
    ),

    'title' => array(
        'title'       => __( 'Title', 'wc-sinopac-payment' ),
        'type'        => 'text',
        'description' => __( 'This controls the title which the user sees during checkout.', 'wc-sinopac-payment' ),
        'default'     => __( 'SinoPac QPay: credit card', 'wc-sinopac-payment' ),
        'desc_tip'    => false,
    ),

    'description' => array(
        'title'       => __( 'Description', 'wc-sinopac-payment' ),
        'type'        => 'text',
        'description' => __( 'Allow your customers make payment with credit card through out SinoPac bank.', 'wc-sinopac-payment' ),
        'default'     => __( 'Have your customers pay with credit card.', 'wc-sinopac-payment' ),
        'desc_tip'    => false,
    ),

    'order_button_text' => array(
        'title'       => __( 'Pay Button', 'wc-sinopac-payment' ),
        'type'        => 'text',
        'description' => __( 'Set if the place order button should be renamed on selection.', 'wc-sinopac-payment' ),
        'default'     => __( 'Proceed to Pay', 'wc-sinopac-payment' ),
        'desc_tip'    => false,
    ),

    'advanced' => array(
		'title'       => __( 'Advanced options', 'wc-sinopac-payment' ),
		'type'        => 'title',
		'description' => '',
	),

    'testmode' => array(
		'title'       => __( 'Sandbox', 'wc-sinopac-payment' ),
		'type'        => 'checkbox',
		'label'       => __( 'Enable sandbox mode', 'wc-sinopac-payment' ),
		'default'     => 'no',
		'description' => sprintf( 
            __( 'Sandbox mode can be used to test payments. Sign up for a <a href="%s">developer account</a>.', 'wc-sinopac-payment' ), 
            'https://developer.sinopac.com/'
        ),
	),

	'api_details' => array(
		'title' => __( 'API credentials', 'wc-sinopac-payment' ),
		'type'  => 'title',
	),

	'api_shop_no' => array(
		'title' => __( 'Shop No.', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'api_hash_a1' => array(
		'title' => 'A1 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'api_hash_a2' => array(
		'title' => 'A2 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'api_hash_b1' => array(
		'title' => 'B1 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'api_hash_b2' => array(
		'title' => 'B2 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'test_details' => array(
		'title' => __( 'Sandbox credentials', 'wc-sinopac-payment' ),
		'type'  => 'title',
	),

	'test_shop_no' => array(
		'title' => __( 'Shop No.', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'test_hash_a1' => array(
		'title' => 'A1 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'test_hash_a2' => array(
		'title' => 'A2 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'test_hash_b1' => array(
		'title' => 'B1 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),

	'test_hash_b2' => array(
		'title' => 'B2 - ' . __( 'Hash key', 'wc-sinopac-payment' ),
		'type'  => 'text',
	),
);

return $settings;
