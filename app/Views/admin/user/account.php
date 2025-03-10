<?php
// echo json_encode($result['username']);
?>

<div class="tab-pane show" id="account" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='entypo-globe'></i>
                        <?= lang('user.public_info') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class='row list-alert-container hidden'>
            <div class='col-xs-12 info'>

            </div>
        </div>

        <div class="card-body">
            <div class="panel-body public-content">
                <form role="form" id="frm_edit_public" method="post" action="<?= site_url('users/update/public/'); ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container public">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= $parent_id ?>">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label col-xs-4" for="username"><?= lang('user.user_name') ?></label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="username" id="username" value="<?= $result['username']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-4" for="biography"><?= lang('user.user_biography') ?></label>
                                <div class="col-xs-6">
                                    <textarea rows="2" class="form-control" name="biography" id="biography" value="<?= $result['biography']; ?>"><?= $result['biography']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <img alt="Andrew Jones" src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                <div class="mt-2">
                                    <span class="btn btn-primary"><i class="fa fa-upload"></i></span>
                                </div>
                                <small><?= lang('user.image_format') ?></small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="public_account_save" class="btn btn-success"><?= lang('user.save_changes_btn') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye-slash'></i>
                        <?= lang('user.private_info') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class='row list-alert-container hidden'>
            <div class='col-xs-12 info'>

            </div>
        </div>
        
        <div class="card-body">
            <div class="panel-body private-content">
                <form role="form" id="frm_edit_private" method="post" action="<?= site_url('users/update/private/'); ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container private">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= $parent_id ?>">

                    <div class="form-group">
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="first_name"><?= lang('user.user_first_name') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result['first_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="last_name"><?= lang('user.user_last_name') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $result['last_name']; ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="email"><?= lang('user.user_email') ?></label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="email" id="email" value="<?= $result['email']; ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="date_of_birth"><?= lang('user.user_dob') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" name="date_of_birth" value="<?= $result['date_of_birth']; ?>" id="date_of_birth">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="gender"><?= lang('user.user_gender') ?></label>
                            <div class="col-xs-6">
                                <select id="gender" name="gender" class="form-control">
                                    <option value="<?= $result['gender']; ?>"><?= ucfirst($result['gender']); ?></option>
                                    <option value="male"><?= lang('system.gender_male') ?></option>
                                    <option value="female"><?= lang('system.gender_female') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label col-xs-4" for="phone"><?= lang('user.user_phone') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="phone" id="phone" value="<?= $result['phone']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="private_account_save" class="btn btn-success"><?= lang('user.save_changes_btn') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#public_account_save', function() {
        let form = $('#frm_edit_public');
        let data = form.serializeArray();
        let error_container = form.find('.error_container .public');
        let url = form.attr('action');

        $.ajax({
            url,
            type: 'POST',
            data,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status,error) {
                error_container.removeClass('hidden');
            }
        })
    })

    $(document).on('click', '#private_account_save', function() {
        let form = $('#frm_edit_private');
        let data = form.serializeArray();
        let error_container = form.find('.error_container .private');
        let url = form.attr('action');

        $.ajax({
            url,
            type: 'POST',
            data,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                error_container.removeClass('hidden').text('An error occured' + error);
            }
        })
    })
</script>