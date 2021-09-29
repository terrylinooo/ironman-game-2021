<form method="POST" autocomplete="off">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row no-gutters justify-content-center">
                    <div class="col-md-6">
                        <h1 class="card-title text-center">結帳</h1>
                        <h3>收件人</h3>
                        <div class="checkout-form">
                            <div class="form-row">
                                <div class="form-group col-md-6 text-left">
                                    <label for="receiver-name">姓名</label>
                                    <input type="text" name="receiver_name" class="form-control" id="receiver-name" required />
                                </div>
                                <div class="form-group col-md-6 text-left">
                                    <label for="receiver-phone">手機</label>
                                    <input type="text" name="receiver_phone" class="form-control" id="receiver-phone" required />
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <label for="receiver-address">收件地址</label>
                                <input type="text" name="receiver_address" class="form-control" id="receiver-address" required />
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>品名</th>
                                <th>數量</th>
                                <th>價格</th>
                            </tr>
                            <tr>
                                <td><?php echo $product['title']; ?></td>
                                <td>1</td>
                                <td>NT $<?php echo $product['price']; ?></td>
                            </tr>
                        </table>
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-center button-box">
                            <button type="submit" class="btn btn-primary btn-lg">進行付款</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="checkout_id" value="<?php echo $product['id']; ?>" />
    <input type="hidden" name="action" value="checkout" />
</form>