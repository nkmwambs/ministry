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
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <?php if(!$numeric_hierarchy_id){?>
                    <div class='form-group'>
                        <label for="hierarchy_id" class="control-label col-xs-4">Hierarchy Name</label>
                        <div class="col-xs-6">
                            <select class="form-control" name="hierarchy_id" id="hierarchy_id">
                                <option value=""><?= lang('hierarchy.select_hierarchy') ?></option>
                                <?php foreach ($hierarchies as $hierarchy) :?>
                                <option value="<?php echo $hierarchy['id'];?>"
                                    <?=$result['hierarchy_id'] == $hierarchy['id'] ? 'selected' : ''; ?>>
                                    <?php echo $hierarchy['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <?php }else{?>
                    <input type="hidden" name="hierarchy_id" id="hierarchy_id" value="<?=$hierarchy_id;?>" />
                    <?php }?>


                    <?php if(!$numeric_department_id){?>
                    <div class='form-group'>
                        <label for="department_id" class="control-label col-xs-4">Department Name</label>
                        <div class="col-xs-6">
                            <select class="form-control" name="department_id" id="department_id">
                                <option value=""><?= lang('department.select_department') ?></option>
                                <?php foreach ($departments as $department) :?>
                                <option value="<?php echo $department['id'];?>"
                                    <?=$result['department_id'] == $department['id'] ? 'selected' : ''; ?>>
                                    <?php echo $department['name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <?php }else{?>
                    <input type="hidden" name="department_id" id="department_id" value="<?=$department_id;?>" />
                    <?php }?>

                    <?php if (!$minister_title_designation) { ?>
                    <div class="form-group">
                        <label class="control-label col-xs-4" for="minister_title_designation">
                            <?= lang('designation.minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="minister_title_designation"
                                name="minister_title_designation">
                                <option value="">Select Minister Title Designation</option>
                                <option value="yes" <?= $minister_title_designation == 'yes' ? 'selected' : ''; ?>>Yes
                                </option>
                                <option value="no" <?= $minister_title_designation == 'no' ? 'selected' : ''; ?>>No
                                </option>
                            </select>
                        </div>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" name="minister_title_designation" id="minister_title_designation"
                        value="<?= $minister_title_designation; ?>" />
                    <?php } ?>


                </form>
            </div>
        </div>
    </div>
</div>