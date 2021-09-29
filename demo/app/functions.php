<?php

use Sinopac\QPay;

/**
 * 讀取 template
 *
 * @param string $path  檔案名稱
 * @param array  $data 引入的變數
 *
 * @return string
 */
function get_template(string $path, array $data = []): string
{
    $path = __DIR__ . '/views/' . $path . '.php';
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
function render(string $path, array $data = []): void
{
    $path = __DIR__ . '/views/' . $path . '.php';
    extract($data, EXTR_OVERWRITE);
    require $path;
    exit;
}

/**
 * 讀取示範商品
 * 
 * @param string $id 商品 ID
 *
 * @return array
 */
function get_product_data(string $id = '0'): array
{
    $raw = file_get_contents(__DIR__ . '/resource/product_data.json');
    $data = json_decode($raw, true);
    if (!empty($id)) {
        foreach ($data as $info) {
            if ($info['id'] == $id) {
                return $info;
            }
        }
    }
    return $data;
}

/**
 * 載入 Controller
 *
 * @param string $path 檔案名稱
 *
 * @return void
 */
function load_controller(string $path): void
{
    $path = __DIR__ . '/controllers/' . $path . '_controller.php';
    if (file_exists($path)) {
        require $path;
    }
}

/**
 * 轉址
 *
 * @param string $url
 *
 * @return string
 */
function redirect(string $url)
{
    header('location: ' . $url, true, 301);
}

/**
 * 建立訂單
 *
 * @param array $data
 *
 * @return bool
 */
function create_order(array $data): bool
{
    $raw = json_encode($data, JSON_PRETTY_PRINT);

    $file = __DIR__ . '/storage/orders/' . $data['order_no'] . '.json';

    if (!file_exists($file)) {
        file_put_contents($file, $raw);
        return true;
    }
    return false;
}

/**
 * 讀取 QPay 實例化後的物件
 * 
 * @return QPay
 */
function get_qpay_instance(): QPay
{
    static $instance;

    if (!$instance) {
        $instance = new QPay([
            'shop_no' => SINOPAC_SHOP_NO,
            'hash' => [
                SINOPAC_HASH_A1,
                SINOPAC_HASH_A2,
                SINOPAC_HASH_B1,
                SINOPAC_HASH_B2,
            ],
        ]);

        if (SINOPAC_SANDBOX) {
            $instance->enableSandbox();
        }
    }

    return $instance;
}