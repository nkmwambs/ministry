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
                        <?= lang('department.add_department') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_denomination" method="post" action="<?= site_url("departments/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (!$numeric_denomination_id) { ?>
                        <div class='form-group'>
                            <label for="denomination_id" class="control-label col-xs-4">Denomination Name</label>
                            <div class="col-xs-6">
                                <select class="form-control" name="denomination_id" id="denomination_id">
                                    <option value=""><?= lang('denomination.select_denomination') ?></option>
                                    <?php foreach ($denominations as $denomination) : ?>
                                        <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
                    <?php } ?>


                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('department.department_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" placeholder="<?= lang('system.system_enter_name') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="department_code">
                            <?= lang('department.department_code') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="department_code" id="department_code" placeholder="<?= lang('department.enter_department_code') ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('department.department_description') ?>
                        </label>
                        <div class="col-xs-6">
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="<?= lang('system.system_enter_description') ?>"></textarea>
                        </div>
                    </div>

                    <!-- Dynamically Generated Custom Fields -->
                    <?php if ($customFields): ?>
                        <?php foreach ($customFields as $field): ?>
                            <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                                <label class="control-label col-xs-4" for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
                                <div class="col-xs-6">
                                    <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>" class="form-control">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </form>

            </div>

        </div>

    </div>
</div>