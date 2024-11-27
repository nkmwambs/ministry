<div class="tab-pane show" id="password" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-key'></i>
                        <?= lang('user.password_reset') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="panel-body">

                <form class="form-horizontal form-groups-bordered" action="<?=site_url('users/profile/account/update/');?>">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label col-xs-4" for="current_password"><?= lang('user.current_password') ?></label>
                            <div class="col-xs-6">
                                <input type="password" class="form-control" id="current_password" name="current_password">
                                <small id="wrong_password_message" style = "color:red;"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-4" for="password"><?= lang('user.new_password') ?></label>
                            <div class="col-xs-6">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-xs-4" for="confirm_password"><?= lang('user.verify_password') ?></label>
                            <div class="col-xs-6">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><?= lang('user.save_changes_btn') ?></button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $('#current_password').on('change', function(){
        const pass_elem = $(this)
        const user_password = $(this).val()
        const user_id = "<?=$parent_id;?>"
        const url = "<?=site_url("users/profile/verify_password");?>"
        const data = {
            user_id,
            user_password
        }

        $.ajax({
            url,
            data,
            method: "POST",
            success: function (response){
                if(!response.success){
                    $("#wrong_password_message").html("<?=lang('user.wrong_password_message');?>")
                    pass_elem.val('')
                }else{
                    $("#wrong_password_message").html("")
                }
            }
        })
    })
</script>