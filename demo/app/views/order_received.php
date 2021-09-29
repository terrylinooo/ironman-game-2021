<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row no-gutters justify-content-center">
                <div class="col-md-6">
                    <h1 class="text-center">購買完成</h1><br />
                    <div class="card">
                        <div class="card-header text-center">
                            訂單交易資訊
                        </div>
                        <div class="card-body" style="height:auto">
                            <p class="card-text">
                                <ul>
                                    <li><label>交易編號</label>：<?php echo $order['transaction_no']; ?></li>
                                    <li><label>訂單編號</label>：<?php echo $order['order_no']; ?></li>
                                    <li><label>付款時間</label>：<?php echo $order['pay_date']; ?></li>
                                    <li><label>付款金額</label>：<?php echo $order['amount']; ?></li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
