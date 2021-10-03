<div class="container">
    <div class="row">
        
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-6 img-box-big">
                        <img src="<?php echo $product['image']; ?>" />
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h1 class="card-title"><?php echo $product['title']; ?></h1>
                            <p class="card-text">
                                <?php echo $product['description']; ?>
                            </p>
                            <h3>NT $<?php echo $product['price']; ?></h3>

                            <div class="checkout-form">
                                <a href="/index.php?page=checkout&product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-lg">
                                    前往結帳
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>