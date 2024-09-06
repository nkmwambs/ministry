<?php 
// echo isset($denomination_entities_count) ? $denomination_entities_count : 0;
?>
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
            
                <form id = "frm_edit_designation" method="post" action="<?=site_url('designation/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name	">
                            <?= lang('designation.designation_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="denomination_id">
                            <?= lang('designation.denomination_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text"  class="form-control" name="code" id="code" value="<?=$result['denomination_id'];?>" placeholder="Denomination Id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="hierarchy_id">
                            <?= lang('designation.hierarchy_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="code" id="code" value="<?=$result['hierarchy_id'];?>" placeholder="Enter hierarchy id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="department_id">
                            <?= lang('designation.department_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="department_id" value="<?=$result['department_id'];?>" id="department_id"
                                placeholder="Enter Department id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="minister_title_designation">
                            <?= lang('designation.minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="minister_title_designation" class="form-control" name="minister_title_designation" id="minister_title_designation" value="<?=$result['minister_title_designation'];?>" placeholder="Enter Minister Title ">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>