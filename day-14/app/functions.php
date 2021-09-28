<?php


/**
 * 讀取 template
 *
 * @param string $path  檔案名稱
 * @param array  $data 引入的變數
 *
 * @return string
 */
function get_template(string $path, array $data = []) {
    $path = __DIR__ . '/templates/' . $path . '.php';
    extract($data, EXTR_OVERWRITE);
    ob_start();
    require $path;
    $ouput = ob_get_clean();
    return $ouput;
}

/**
 * 輸出 template
 *
 * @param string $path 檔案名稱
 * @param array  $data 引入的變數
 * @return void
 */
function render(string $path, array $data = []) {
    $path = __DIR__ . '/templates/' . $path . '.php';
    extract($data, EXTR_OVERWRITE);
    require $path;
}

/**
 * 讀取示範商品
 *
 * @return void
 */
function get_product_data() {
    $data = file_get_contents(__DIR__ . '/resource/product_data.json');
    return json_decode($data, true);
}