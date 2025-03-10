<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('member.edit_member') ?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item active"><a class="nav-link" href="#edit_member_basic"
                                    id="edit_member_tab_basic"
                                    data-toggle="tab"><?= lang('member.edit_member_basic') ?></a></li>
                            <?php if (!empty($customFields)) { ?>
                                <li class="nav-item"><a class="nav-link" href="#edit_member_additional"
                                        id="edit_member_tab_additional"
                                        data-toggle="tab"><?= lang('member.edit_member_additional') ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <form id="frm_edit_member" method="post" action="<?= site_url('members/update/'); ?>" role="form"
                class="form-horizontal form-groups-bordered">
                <div class="tab-content">
                    <div class="tab-pane active" id="edit_member_basic" role="tabpanel">
                        <div class="form-group hidden error_container">
                            <div class="col-xs-12 error"></div>
                        </div>

                        <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />
                        <input type="hidden" name="assembly_id" value="<?= hash_id($result['assembly_id']); ?>" />

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="is_active">
                                <?= lang('member.member_is_active') ?>
                            </label>
                            <div class="col-xs-6">
                                <select type="text" class="form-control" name="is_active" id="is_active">
                                    <option value="" selected><?= lang('member.member_select_is_active') ?></option>
                                    <option value="yes" <?= $result['is_active'] == 'yes' ? "selected" : ""; ?>>
                                        <?php echo lang('system.system_yes'); ?>
                                    </option>
                                    <option value="no" <?= $result['is_active'] == 'no' ? "selected" : ""; ?>>
                                        <?php echo lang('system.system_no'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group hidden">
                            <label class="control-label col-xs-4" for="inactivation_reason">
                                <?= lang('member.member_inactivation_reason') ?>
                            </label>
                            <div class="col-xs-6">
                                <select class="form-control" name="inactivation_reason" id="inactivation_reason"
                                    value="<?= $result['inactivation_reason']; ?>">
                                    <option value=""><?= lang('member.member_inactivation_reason_select') ?></option>
                                    <option value="deceased" <?= $result['inactivation_reason'] == 'deceased' ? "selected" : ""; ?>><?php echo lang('member.member_inactivation_reason_deceased'); ?>
                                    </option>
                                    <option value="excluded" <?= $result['inactivation_reason'] == 'excluded' ? "selected" : ""; ?>><?php echo lang('member.member_inactivation_reason_excluded'); ?>
                                    </option>
                                    <option value="other" <?= $result['inactivation_reason'] == 'other' ? "selected" : ""; ?>>
                                        <?php echo lang('member.member_inactivation_reason_other'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="first_name">
                                <?= lang('member.member_first_name') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    value="<?= $result['first_name']; ?>" placeholder="Enter First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="last_name">
                                <?= lang('member.member_last_name') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    value="<?= $result['last_name']; ?>" placeholder="Enter Last Name">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="designation_id"
                                class="control-label col-xs-4"><?= lang('member.member_gender') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="gender" id="gender">
                                    <option value=""><?= lang('member.member_select_gender') ?></option>
                                    <option value="male" <?= $result['gender'] == 'male' ? "selected" : ""; ?>>
                                        <?php echo lang('system.gender_male'); ?>
                                    </option>
                                    <option value="female" <?= $result['gender'] == 'female' ? "selected" : ""; ?>>
                                        <?php echo lang('system.gender_female'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="membership_date"
                                class="control-label col-xs-4"><?= lang('member.membership_date') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" id="membership_date"
                                    name="membership_date" value="<?= $result['membership_date']; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="member_number">
                                <?= lang('member.member_member_number') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" readonly name="member_number" id="member_number"
                                    value="<?= $result['member_number']; ?>" placeholder="Enter Member Number">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="designation_id"
                                class="control-label col-xs-4"><?= lang('member.member_designation_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="designation_id" id="designation_id">

                                    <?php if (!empty($designations)) {
                                        foreach ($designations as $designation) {
                                            ?>
                                            <option value="<?= $designation['id']; ?>"
                                                <?= $result['designation_id'] == $designation['id'] ? "selected" : ""; ?>>
                                                <?= $designation['name']; ?>
                                            </option>
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
                                <input type="text" class="form-control datepicker" name="date_of_birth"
                                    id="date_of_birth" value="<?= $result['date_of_birth']; ?>"
                                    placeholder="Enter Date of Birth">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="email">
                                <?= lang('member.member_email') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?= $result['email']; ?>" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="phone">
                                <?= lang('member.member_phone') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="phone" id="phone"
                                    value="<?= $result['phone']; ?>" placeholder="Enter Phone"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="saved_date">
                                <?= lang('member.saved_date') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" name="saved_date" id="saved_date"
                                    value="<?= $result['saved_date']; ?>" placeholder="Enter Saved Date"></i>
                            </div>
                        </div>

                    </div>
                    <?php 
                        $tab_pane_id = "edit_member_additional";
                    ?>
                    <?=view_cell('CustomEditTabPaneCell', compact('customFields','customValues','tab_pane_id'));?>

                </div>
            </form>
        </div>
    </div>
</div>