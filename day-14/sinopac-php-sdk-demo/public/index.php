<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_DIR', __DIR__);

$page = $_GET['page'] ?? 'home';

include BASE_DIR . '/functions.php';

$data = [];

switch ($page) {
    case 'home': 
        $data['products'] = get_product_data();
        $data['body'] = get_template('home', $data);;
        break;

    case 'product':
        $body = get_template('product', $data);;
        break;

    case 'checkout':
        $data['body'] = get_template('checkout', $data);;
        break;

    case 'order_received':
        $data['body'] = get_template('order_received', $data);;
        break;

    default:
        http_response_code(404);
        exit('404/Page not found.');
}

render('main', $data);