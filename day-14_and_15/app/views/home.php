<div class="container">
    <div class="row">
        <?php foreach($products as $product) : ?>
            <div class="col-md-3">
                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 box-shadow">
                        <div class="card-body">
                            <div class="text-center img-box">
                                <img src="<?php echo $product['image']; ?>" class="rounded" />
                            </div>
                            <h3><?php echo $product['title']; ?></h3>
                            <div class="text-secondary">
                                <?php echo $product['description']; ?>
                            </div>
                            <div class="pricing-box">
                                <h2 class="card-title pricing-card-title">
                                    <?php echo $product['price']; ?> 元
                                </h2>
                                <a type="button" 
                                    class="btn btn-lg btn-block btn-outline-primary" 
                                    href="/index.php?page=product&product_id=<?php echo $product['id']; ?>">
                                    購買
                                </a>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>