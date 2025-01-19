<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <h1><?= date('F, d Y') ?></h1>
            <h3><?= lang('system.dashboard_welcome'); ?> <strong><?= session()->get('user_fullname'); ?></strong></h3>
        </div>
    </div>
</div>