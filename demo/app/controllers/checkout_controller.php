<?php

/**
 * Checkout controller.
 */
(function(){
    global $page;

    $id = $_GET['product_id'] ?? '0';
    
    $data['page'] = $page;
    $data['product'] = get_product_data($id);
    $data['body'] = get_template('checkout', $data);

    render('main', $data);

})();