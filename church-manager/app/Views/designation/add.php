<?php 
$numeric_denomination_id= hash_id($parent_id, 'decode');
// $numeric_hierarchy_id= hash_id($hierarchy_id, 'decode');
// $numeric_department_id= hash_id($department_id, 'decode');

?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('designation.add_designation') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_designation" method="post" action="<?= site_url("designations/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (!$numeric_denomination_id) { ?>
                        <div class = 'form-group'>
                            <label for="denomination_id" class = "control-label col-xs-4">Denomination Name</label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "denomination_id" id = "denomination_id">
                                    <option value ="">Select a denomination</option>
                                    <?php foreach ($denominations as $denomination) : ?>
                                        <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="denomination_id" id = "denomination_id" value="<?= $parent_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('designation.designation_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_minister_title_designation">
                            <?= lang('designation.is_minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="is_minister_title_designation" name="is_minister_title_designation" >
                                <option><?=lang('designation.is_minister_title_designation');?></option>
                                <option value="yes"><?=lang('system.system_yes');?></option>
                                <option value="no" selected><?=lang('system.system_no');?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_hierarchy_leader_designation">
                            <?= lang('designation.is_hierarchy_leader_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="is_hierarchy_leader_designation" name="is_hierarchy_leader_designation" >
                                <option><?=lang('designation.is_hierarchy_leader_designation');?></option>
                                <option value="yes"><?=lang('system.system_yes');?></option>
                                <option value="no" selected><?=lang('system.system_no');?></option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_department_leader_designation">
                            <?= lang('designation.is_department_leader_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="is_department_leader_designation" name="is_department_leader_designation" >
                                <option><?=lang('designation.is_department_leader_designation');?></option>
                                <option value="yes"><?=lang('system.system_yes');?></option>
                                <option value="no" selected><?=lang('system.system_no');?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamically Generated Custom Fields -->
                    <?php foreach ($customFields as $field): ?>
                        <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                            <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
                            <div class="col-xs-6">
                                <input type="<?= $field['type'] ?>" name="custom_fields[<?= $field['id'] ?>]" id="<?= $field['field_name'] ?>" class="form-control">
                            </div>
                        </div>
                    <?php endforeach; ?>

                </form>

            </div>

        </div>

    </div>
</div>
