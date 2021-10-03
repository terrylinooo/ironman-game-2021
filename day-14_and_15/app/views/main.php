<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Terry 示範網站</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="/style.css"> 
</head>
<body class="page-<?php echo $page; ?>">
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">Terry's 商店</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/index.php">首頁</a>
        <a class="p-2 text-dark" href="/index.php">夏季特賣</a>
    </nav>
    <a class="btn btn-outline-primary" href="#">註冊</a>
</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">特價</h1>
    <p class="lead">要買要快，不然不賣。</p>
</div>

<div class="container">
    <div id="main-body">
        <?php echo $body; ?>
    </div>
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md text-center">
               2021 鐵人賽 - Terry L.
            </div>
        </div>
    </footer>
</div>
</body>
</html>
