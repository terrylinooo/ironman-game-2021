<?php

/**
 * Home controller.
 */
(function() {
    global $page;

    $data['page'] = $page;
    $data['products'] = get_product_data();
    $data['body'] = get_template('home', $data);
    
    render('main', $data);
})();

