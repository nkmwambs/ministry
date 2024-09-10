<?php 
// echo json_encode($result);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('role.edit_role') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <form id="frm_edit_role" method="post" action="<?=site_url('roles/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" id = "role_id" value="<?=$id;?>" />

                    <?php if(!$numeric_denomination_id){?>
                        <div class = 'form-group'>
                            <label for="denomination_id" class = "control-label col-xs-4"><?= lang('role.role_denomination_name') ?></label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "denomination_id" id = "denomination_id">
                                    <option value =""><?= lang('denomination.select_denomination') ?></option>
                                    <option value ="0" <?=$result['denomination_id'] == null ? 'selected': '';?> ><?= lang('role.system_denomination') ?></option>
                                    <?php foreach ($denominations as $denomination) :?>
                                        <option value="<?php echo $denomination['id'];?>" <?=$result['denomination_id'] == $denomination['id'] ? 'selected' : ''; ?>><?php echo $denomination['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    <?php }else{?>
                        <input type="hidden" name="denomination_id" id = "denomination_id" value="<?=$parent_id;?>" />
                    <?php }?>


                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('role.role_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" value="<?=$result['name'];?>"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="default_role">
                            <?= lang('role.role_default') ?>
                        </label>
                        <div class="col-xs-6">
                            
                            <select <?=$result['default_role'] == 'no' ? 'readonly' : '';?> class="form-control" name="default_role" id="default_role">
                                <option value="no" <?=$result['default_role'] == 'no' ? 'selected': '';?>>No</option>
                                <option value="yes" <?=$result['default_role'] == 'yes' ? 'selected' : '';?> >Yes</option>
                            </select>
                        </div>
                    </div>
                </form> 
            </div>

        </div>

    </div>
</div>