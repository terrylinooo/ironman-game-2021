<?php

/**
 * Checkout controller.
 */
function order_received()
{
    global $page;

    $shopNo = $_POST['ShopNo'] ?? '';
    $payToken = $_POST['PayToken'] ?? '';

    $success = false;
    $order = [];

    if ($shopNo === SINOPAC_SHOP_NO && $payToken !== '') {
        $qpay = get_qpay_instance();
        $results = $qpay->queryOrderByToken($payToken);

        if (!empty($results['Message'])) {
            if ($results['Message']['Status'] === 'S') {
                $success = true;
                $transaction = $results['Message']['TSResultContent'];

                $order['order_no'] = $transaction['OrderNo'];
                $order['transaction_no'] = $transaction['TSNo'];
                $order['pay_date'] = date('Y/m/d H:i', strtotime($transaction['PayDate']));
                $order['amount'] = $transaction['Amount'] / 100;
            }
        }
    }

    $data['page'] = $page;
    $data['success'] = $success;
    $data['order'] = $order;
    $data['body'] = get_template('order_received', $data);

    render('main', $data);
}

order_received();