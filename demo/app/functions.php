<?php

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