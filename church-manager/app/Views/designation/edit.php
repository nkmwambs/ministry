<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('designation.edit_designation') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <?php 
                // echo json_encode($result);
                ?>

                <form id="frm_edit_designation" method="post" action="<?=site_url('designations/update/');?>"
                    role="form" class="form-horizontal form-groups-bordered">

                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if(!$numeric_denomination_id){?>
                    <div class='form-group'>
                        <label for="denomination_id" class="control-label col-xs-4">Denomination Name</label>
                        <div class="col-xs-6">
                            <select class="form-control" name="denomination_id" id="denomination_id">
                                <option value=""><?= lang('denomination.select_denomination') ?></option>
                                <?php foreach ($denominations as $denomination) :?>
                                <option value="<?php echo $denomination['id'];?>"
                                    <?=$result['denomination_id'] == $denomination['id'] ? 'selected' : ''; ?>>
                                    <?php echo $denomination['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <?php }else{?>
                    <input type="hidden" name="denomination_id" id="denomination_id" value="<?=$parent_id;?>" />
                    <?php }?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name	">
                            <?= lang('designation.designation_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="<?=lang('system.system_enter_name');?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_minister_title_designation">
                            <?= lang('designation.is_minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="is_minister_title_designation" name="is_minister_title_designation" >
                                <option><?=lang('designation.is_minister_title_designation');?></option>
                                <option value="yes" <?=$result['is_minister_title_designation'] == 'yes' ? 'selected':'';?> ><?=lang('system.system_yes');?></option>
                                <option value="no" <?=$result['is_minister_title_designation'] == 'no' ? 'selected':'';?> ><?=lang('system.system_no');?></option>
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
                                <option value="yes" <?=$result['is_hierarchy_leader_designation'] == 'yes' ? 'selected':'';?> ><?=lang('system.system_yes');?></option>
                                <option value="no" <?=$result['is_hierarchy_leader_designation'] == 'no' ? 'selected':'';?> ><?=lang('system.system_no');?></option>
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
                                <option value="yes" <?=$result['is_department_leader_designation'] == 'yes' ? 'selected':'';?> ><?=lang('system.system_yes');?></option>
                                <option value="no" <?=$result['is_department_leader_designation'] == 'no' ? 'selected':'';?> ><?=lang('system.system_no');?></option>
                            </select>
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
        </div>
    </div>
</div>