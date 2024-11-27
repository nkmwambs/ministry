<div class="tab-pane show" id="password" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-trash'></i>
                        <?= lang('user.delete_account') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="panel-body">
                <button class="btn btn-danger" id="data_button" style="width:100%"><i class="fa fa-trash"> </i><?= lang('user.delete_account') ?></button>
            </div>
        </div>

    </div>
</div>

<script>

    $(document).on('click',function() {
        $('#data_button').click(function() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                // Redirect to the delete account route
                window.location.href = "<?= site_url('users/deleteAccount'); ?>";
            }
        });
    });
</script>