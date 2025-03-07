<?php 
// $mpesaLibrary = new \App\Libraries\MPesaLibrary();
// $denominationCode = "COGOP-WC2025";
// $payment_purpose = "Payment of Women Conference";
// $paying_number = "254711808071";
// $amount = 1; 
// echo $mpesaLibrary->express($denominationCode, $payment_purpose, $paying_number, $amount);
// echo $mpesaLibrary->registerUrls();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h1><?= date('F, d Y') ?></h1>
            <h3><?= lang('system.dashboard_welcome'); ?> <strong><?= session()->get('user_fullname'); ?></strong></h3>
        </div>
    </div>
</div>