<?php

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
    case 'checkout':
    case 'product':
        load_controller($page);
        break;

    case 'order_received':
        load_controller('order');
        break;

    default:
        http_response_code(404);
        exit('404/Page not found.');
}