<div class="card">
    <div class="card-header">
        <div class="card-actions float-right">
            <div class="dropdown show">
                <a href="#" data-toggle="dropdown" data-display="static">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <div class="page-title mb-0"><i class="fa fa-user"></i>
            <?= lang('user.profile_settings') ?>
        </div>
    </div>

    <div class="list-group list-group-flush" role="tablist">
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" data-profile = "account" role="tab">
            <i class="fa fa-user" ?></i>
            <?= lang('profile.account') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" data-profile = "password_reset" href="#" role="tab">
            <i class="fa fa-key" ></i>
            <?= lang('profile.password') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="<?= site_url("users/privacy"); ?>" role="tab">
            <i class="fa fa-shield" ></i>
            <?= lang('profile.privacy_and_safety') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
            <?= lang('profile.email_notifications') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
            <?= lang('profile.web_notifications') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
            <?= lang('profile.widgets') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
            <?= lang('profile.your_data') ?>
        </a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
            <?= lang('profile.delete_account') ?>
        </a>
    </div>
</div>

