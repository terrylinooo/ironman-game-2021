# Ironman Game 13th (2021)

[永豐金 API - 豐支付 PHP SDK 設計及 WooCommerce 電商串接實戰](https://ithelp.ithome.com.tw/users/20111119/ironman/4406) 範例集

## SinoPac API Doc

豐支付 API 鐵人賽文件 [./doc/api-specs-1.15.pdf](./doc/api-specs-1.15.pdf) 文件版權為永豐金所有。
為避免文章篇幅放置文件截圖過長，以及片段不完整，故放上來，請讀者搭配閱讀。

## Index

- [Day 1 - 前言，寫作動機分享與準備事項](https://ithelp.ithome.com.tw/articles/10264556)
- [Day 2 - API 文件導覽、 Postman 測試取得 Nonce](https://ithelp.ithome.com.tw/articles/10265648)
- [Day 3 - 安全簽章: HashId 計算](https://ithelp.ithome.com.tw/articles/10266442)
- [Day 4 - 安全簽章: 訊息內文雜湊](https://ithelp.ithome.com.tw/articles/10266896)
- [Day 5 - 安全簽章: 取得 SHA256 加密後的 Sign 值](https://ithelp.ithome.com.tw/articles/10267405)
- [Day 6 - 產生內文加密所需的 IV 值](https://ithelp.ithome.com.tw/articles/10268021)
- [Day 7 - 使用 AES-CBC 機制對 Message 內文進行加密](https://ithelp.ithome.com.tw/articles/10268975)
- [Day 8 - 使用 Order API 建立測試訂單](https://ithelp.ithome.com.tw/articles/10269982)
- [Day 9 - 解密 Order API 回傳的 Message 字串](https://ithelp.ithome.com.tw/articles/10270258)
- [Day 10 - API 文件導覽總結 - 重點整理](https://ithelp.ithome.com.tw/articles/10271363)
- [Day 11 - 豐收款非官方 PHP SDK 發佈](https://ithelp.ithome.com.tw/articles/10271376)
- [Day 12 - PHP SDK: 建立信用卡、虛擬帳號訂單](https://ithelp.ithome.com.tw/articles/10272507)
- [Day 13 - PHP SDK: 查詢訂單狀態](https://ithelp.ithome.com.tw/articles/10273587)
- [Day 14 - PHP SDK: 用 Pure PHP 建立購物網 (上)](https://ithelp.ithome.com.tw/articles/10274257)
- [Day 15 - PHP SDK: 用 Pure PHP 建立購物網 (下)](https://ithelp.ithome.com.tw/articles/10274889)
- [Day 16 - WooCommerce 金流串接 - 前言](https://ithelp.ithome.com.tw/articles/10275533)
- [Day 17 - WooCommerce 測試環境建立 (上)](https://ithelp.ithome.com.tw/articles/10275985)
- [Day 18 - WooCommerce 測試環境建立 (下)](https://ithelp.ithome.com.tw/articles/10276471)
- [Day 19 - WooCommerce: 初始化付款外掛](https://ithelp.ithome.com.tw/articles/10276839)
- [Day 20 - WooCommerce: 定義信用卡付款閘道](https://ithelp.ithome.com.tw/articles/10277614)
- [Day 21 - WooCommerce: 信用卡付款設定選項 (上)](https://ithelp.ithome.com.tw/articles/10278049)
- [Day 22 - WooCommerce: 信用卡付款設定選項 (下)](https://ithelp.ithome.com.tw/articles/10278513)
- [Day 23 - WooCommerce: 建立信用卡付款訂單 (上)](https://ithelp.ithome.com.tw/articles/10279388)
- [Day 24 - WooCommerce: 建立信用卡付款訂單 (下)](https://ithelp.ithome.com.tw/articles/10279388)
- [Day 25 - WooCommerce: 驗收永豐銀行刷卡流程](https://ithelp.ithome.com.tw/articles/10279668)
- [Day 26 - WooCommerce: 定義虛擬帳號付款閘道](https://ithelp.ithome.com.tw/articles/10280350)
- [Day 27 - WooCommerce: 建立虛擬帳號付款訂單](https://ithelp.ithome.com.tw/articles/10280350)
- [Day 28 - WooCommerce: 顯示虛擬帳號付款資訊](https://ithelp.ithome.com.tw/articles/10281031)
- [Day 29 - WooCommerce: 接收虛擬帳號付款成功通知](https://ithelp.ithome.com.tw/articles/10281372)
- [Day 30 - 永豐銀行付款外掛發佈、鐵人賽總結](https://ithelp.ithome.com.tw/articles/10281680)
