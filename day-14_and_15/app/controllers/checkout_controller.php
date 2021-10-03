<?php

use Sinopac\Exception\QPayException;

/**
 * Checkout controller.
 */
(function() {
    global $page;

    checkout_handler();

    $id = $_GET['product_id'] ?? '0';
    $error = $_GET['error'] ?? '';
    
    $data['page'] = $page;
    $data['error'] = $error;
    $data['product'] = get_product_data($id);
    $data['body'] = get_template('checkout', $data);

    render('main', $data);

})();

function checkout_handler()
{
    $action = $_POST['action'] ?? '';
    $productId = $_POST['checkout_id'] ?? 0;

    if (!$action === 'checkout' || !$productId) {
        return;
    }

    $order = [];

    // 訂購的商品資訊
    $product = get_product_data($productId);

    $order['order_no'] = 'DEMO' . date('Ymdhis');
    $order['product_name'] = $product['title'];
    $order['total'] = $product['price'];

    // 收貨人資訊
    $order['receiver_name'] = $_POST['receiver_name'] ?? '未填姓名';
    $order['receiver_phone'] = $_POST['receiver_phone'] ?? '未填電話';
    $order['receiver_address'] = $_POST['receiver_address'] ?? '未填地址';

    $order['api_data'] = [
        'order_no'        => $order['order_no'],
        'amount'          => $order['total'] * 100,
        'cc_auto_billing' => 'Y',
        'product_name'    => $order['product_name'],
        'return_url'      => QPAY_RETURN_URL,
        'backend_url'     => QPAY_BACKEND_URL,
    ];

    if (create_order($order)) {
        $qpay = get_qpay_instance();

        try {
            $results = $qpay->createOrderByCreditCard($order['api_data']);
            checkout_message_parser($results);
        } catch (QPayException $e) {
            $url = './index.php?page=checkout&product_id=' . $productId . '&error=' . $e->getMessage();
            redirect($url);
        }
    }
}

function checkout_message_parser($results)
{
    $success = false;

    if (!empty($results['Message'])) {
        $success = ($results['Message']['Status'] === 'S');

        if ($results['Message']['PayType'] === 'C') {
            $url = $results['Message']['CardParam']['CardPayURL'];
            redirect($url);
        }
    }

    if (!$success) {
        $data['error_data'] = $results;
        $data['body'] = get_template('order_error', $data);
        render('main', $data);
    }
}