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
                            <h1 class="card-title text-error">結帳失敗</h1>
                            <p class="card-text">
                                <pre><?php echo json_encode($error_data, JSON_PRETTY_PRINT); ?></pre>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>