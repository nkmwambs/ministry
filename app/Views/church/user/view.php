<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<div class="row">
    <?php if (session()->getFlashdata('message')) { ?>
        <div class="col-xs-12 info">
            <p><?= session()->getFlashdata('message'); ?></p>
            <a href="<?= site_url(plural($feature)) ?>"><?= lang('user.edit_again_buttton') ?></a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('user.view_user'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class='row'>
                    <div class="col-xs-12" id="view_profile">
                        <?= view('church/user/profile') ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.list-group-item:first').trigger('click');
    })

    $('.list-group-item-action').on('click', function(ev) {
        const url = "<?= site_url("church/users/profile") ?>"

        $.ajax({
            url: url + '/' + $(this).data('profile') + '/<?= $id; ?>',
            type: 'GET',
            beforeSend: function() {
                $("#overlay").css("display", "block");
            },
            success: function(data) {
                $('#profile_data').html(data);
                $("#overlay").css("display", "none");
            },
            error: function(xhr, status, error) {
                $('#profile_data').html('<div class="error">Error Occurred</div>');
                $("#overlay").css("display", "none");
            }
        })

        ev.preventDefault()
    })
</script>
