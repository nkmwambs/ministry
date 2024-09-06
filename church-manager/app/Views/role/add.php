<?php 
$numeric_denomination_id = hash_id($parent_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('role.add_role') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm-view_roles" method="post" action="<?= site_url("roles/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (!$numeric_denomination_id) { ?>
                        <div class = 'form-group'>
                            <label for="denomination_id" class = "control-label col-xs-4"><?= lang('role.role_denomination_name') ?></label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "denomination_id" id = "denomination_id">
                                    <option value =""><?= lang('role.select_denomination') ?></option>
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
                            <?= lang('role.role_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="permissions">
                            <?= lang('role.role_permissions') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="permissions" id="permissions" placeholder="Enter Permissions">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="default_role">
                            <?= lang('role.role_default') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="default_role" id="default_role" placeholder="Enter Default Role">
                        </div>
                    </div>
                    
                </form>

            </div>

        </div>

    </div>
</div>