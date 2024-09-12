<?php 
$numeric_denomination_id= hash_id($parent_id, 'decode');
$numeric_hierarchy_id= hash_id($hierarchy_id, 'decode');
$numeric_department_id= hash_id($department_id, 'decode');

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

                    <?php if (!$numeric_hierarchy_id) { ?>
                        <div class = 'form-group'>
                            <label for="hierarchy_id" class = "control-label col-xs-4">Hierarchy Name</label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "hierarchy_id" id = "hierarchy_id">
                                    <option value ="">Select a Hierarchy</option>
                                    <?php foreach ($hierarchies as $hierarchy) : ?>
                                        <option value="<?php echo $hierarchy['id']; ?>"><?php echo $hierarchy['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="text" name="hierarchy_id" id = "hierarchy_id" value="<?= $hierarchy_id; ?>" />
                    <?php } ?>

                    <?php if (!$numeric_department_id) { ?>
                        <div class = 'form-group'>
                            <label for="department_id" class = "control-label col-xs-4">Department Name</label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "department_id" id = "department_id">
                                    <option value ="">Select a Department</option>
                                    <?php foreach ($departments as $department) : ?>
                                        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="text" name="department_id" id = "department_id" value="<?= $department_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="minister_title_designation">
                            <?= lang('designation.minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" id="minister_title_designation" name="minister_title_designation" >
                                <option>Select Minister Title Designation</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    
                    
                </form>

            </div>

        </div>

    </div>
</div>
