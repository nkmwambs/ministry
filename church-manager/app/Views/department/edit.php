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
                        <?= lang('department.edit_department') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <form id="frm_edit_assembly" method="post" action="<?=site_url('departments/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" id = "department_id" value="<?=$id;?>" />

                    <?php if(!$numeric_denomination_id){?>
                        <div class = 'form-group'>
                            <label for="denomination_id" class = "control-label col-xs-4">Denomination Name</label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "denomination_id" id = "denomination_id">
                                    <option value =""><?= lang('denomination.select_denomination') ?></option>
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
                            <?= lang('department.department_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" value="<?=$result['name'];?>"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('department.department_description') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="description" id="description" value = "<?=$result['description'];?>" placeholder="Enter Description">
                        </div>
                    </div>
                </form> 
            </div>

        </div>

    </div>
</div>