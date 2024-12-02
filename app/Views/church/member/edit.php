<?php
// echo json_encode($designations);
?>

<syle>

</syle>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('member.edit_member') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_member" method="post" action="<?= site_url('church/members/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />
                    <input type="hidden" name="assembly_id" value="<?= hash_id($result['assembly_id']); ?>" />

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_active">
                            <?= lang('member.member_is_active') ?>
                        </label>
                        <div class="col-xs-6">
                            <select type="text" class="form-control" name="is_active" id="is_active">
                                <option value="" selected><?= lang('system.system_active') ?></option>
                                <option value="yes" <?= $result['is_active'] == 'yes' ? "selected" : ""; ?>><?php echo lang('system.system_yes'); ?></option>
                                <option value="no" <?= $result['is_active'] == 'no' ? "selected" : ""; ?>><?php echo lang('system.system_no'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group hidden">
                        <label class="control-label col-xs-4" for="inactivation_reason">
                            <?= lang('member.member_inactivation_reason') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" name="inactivation_reason" id="inactivation_reason" value="<?= $result['inactivation_reason']; ?>">
                                <option value=""><?= lang('member.member_inactivation_reason_select') ?></option>
                                <option value="deceased" <?= $result['inactivation_reason'] == 'deceased' ? "selected" : ""; ?>><?php echo lang('member.member_inactivation_reason_deceased'); ?></option>
                                <option value="excluded" <?= $result['inactivation_reason'] == 'excluded' ? "selected" : ""; ?>><?php echo lang('member.member_inactivation_reason_excluded'); ?></option>
                                <option value="other" <?= $result['inactivation_reason'] == 'other' ? "selected" : ""; ?>><?php echo lang('member.member_inactivation_reason_other'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="first_name">
                            <?= lang('member.member_first_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result['first_name']; ?>" placeholder="Enter First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="last_name">
                            <?= lang('member.member_last_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $result['last_name']; ?>" placeholder="Enter Last Name">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_gender') ?></label>
                        <div class="col-xs-6">
                            <select class="form-control" name="gender" id="gender">
                                <option value=""><?= lang('member.member_select_gender') ?></option>
                                <option value="male" <?= $result['gender'] == 'male' ? "selected" : ""; ?>><?php echo lang('system.gender_male'); ?></option>
                                <option value="female" <?= $result['gender'] == 'female' ? "selected" : ""; ?>><?php echo lang('system.gender_female'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="membership_date" class="control-label col-xs-4"><?= lang('member.membership_date') ?></label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" id="membership_date" name="membership_date" value="<?= $result['membership_date']; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_number">
                            <?= lang('member.member_member_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" readonly name="member_number" id="member_number" value="<?= $result['member_number']; ?>" placeholder="Enter Member Number">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_designation_id') ?></label>
                        <div class="col-xs-6">
                            <select class="form-control" name="designation_id" id="designation_id">

                                <?php if (!empty($designations)) {
                                    foreach ($designations as $designation) {
                                ?>
                                        <option value="<?= $designation['id']; ?>" <?= $result['designation_id'] == $designation['id'] ? "selected" : ""; ?>><?= $designation['name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="date_of_birth">
                            <?= lang('member.member_date_of_birth') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" value="<?= $result['date_of_birth']; ?>" placeholder="Enter Date of Birth">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="email">
                            <?= lang('member.member_email') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="email" id="email" value="<?= $result['email']; ?>" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">
                            <?= lang('member.member_phone') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="phone" id="phone" value="<?= $result['phone']; ?>" placeholder="Enter Phone"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="saved_date">
                            <?= lang('member.saved_date') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="saved_date" id="saved_date" value="<?= $result['saved_date']; ?>" placeholder="Enter Saved Date"></i>
                        </div>
                    </div>

                    <?php if (!empty($customFields)): ?>
                        <?php foreach ($customFields as $field): ?>
                            <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                                <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
                                <div class="col-xs-6">
                                    <input type="<?= $field['type'] ?>"
                                        name="custom_fields[<?= $field['id'] ?>]"
                                        id="<?= $field['field_name'] ?>"
                                        value="<?= $customFieldValuesInDB['value'] ?? '' ?>"
                                        class="form-control">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('system.system_close') ?></button>
                <button type="button" id="modal_reset" class="btn btn-danger"><?= lang('system.system_reset') ?></button>
                <button type="button" id="form_save" data-item_id="" data-feature_plural="" class="btn btn-success"><?= lang('system.system_save') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#form_save", function() {
        const panelBody = $(this).closest('.panel-body');
        const form = panelBody.find('form');
        const data = form.serializeArray();
        const url = form.attr('action');
        const saveButton = $(this);

        // Disable button and show loading text
        saveButton.prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
                alert('Form submitted successfully!');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred. Please try again.');
            },
            complete: function() {
                saveButton.prop('disabled', false).text('Save');
            }
        });
    });
</script>