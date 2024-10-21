<?php
// $numeric_assembly_id = hash_id($designation_id, 'decode');
// $numeric_designation_id = hash_id($designation_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i>
                        <?= lang('field.edit_customfield') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_minister" method="post" action="<?= site_url('fields/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (session()->get('errors')): ?>
                        <div class="form-group">
                            <div class="col-xs-12 error">
                                <ul>
                                    <?php foreach (session()->get('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />

                    <div class='form-group'>
                        <label for="feature_id" class="control-label col-xs-4">
                            <?= lang('field.customfield_feature_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" name="feature_id" id="feature_id">
                                <option value="<?= $result['feature_id'] ?>"><?= $result['feature_id'] ?></option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="table_name">
                            <?= lang('field.customfield_table_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="table_name" value="<?= $result['table_name']; ?>" id="table_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="field_name">
                            <?= lang('field.customfield_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="field_name" value="<?= $result['field_name']; ?>" id="field_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="field_code">
                            <?= lang('field.customfield_code') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="field_code" value="<?= $result['field_code']; ?>" id="field_code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="helptip">
                            <?= lang('field.customfield_helptip') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="helptip" value="<?= $result['helptip']; ?>" id="helptip">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="type" class="control-label col-xs-4">
                            <?= lang('field.customfield_type') ?>
                        </label>
                        <div class="col-xs-6">
                            <select name="type" id="type" class="form-control" required>
                                <option value="<?= $result['type']; ?>"><?= ucfirst($result['type']); ?></option>
                                <option value="text"><?= lang('field.text') ?></option>
                                <option value="float"><?= lang('field.float') ?></option>
                                <option value="date"><?= lang('field.date') ?></option>
                                <option value="datetime"><?= lang('field.datetime') ?></option>
                                <option value="timestamp"><?= lang('field.timestamp') ?></option>
                                <option value="password"><?= lang('field.password') ?></option>
                                <option value="numeric"><?= lang('field.numeric') ?></option>
                                <option value="email"><?= lang('field.email') ?></option>
                                <option value="dropdown"><?= lang('field.dropdown') ?></option>
                                <option value="boolean"><?= lang('field.boolean') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="options">
                            <?= lang('field.customfield_options') ?>
                        </label>
                        <div class="col-xs-6">
                            <textarea type="text" class="form-control" name="options" value="<?= $result['options']; ?>" id="options"><?= $result['options']; ?></textarea>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="control-label col-xs-4" for="field_order">
                            <?= lang('field.customfield_field_order') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="field_order" value="<?= $result['field_order']; ?>" id="field_order"
                                placeholder="Edit Field Order">
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="visible">
                            <?= lang('field.customfield_visible') ?>
                        </label>
                        <div class="col-xs-6">
                            <select name="visible" id="visible" class="form-control" required>
                                <option value="<?= $result['visible']; ?>"><?= ucfirst($result['visible']); ?></option>
                                <option value="no"><?= lang('system.system_no') ?></option>
                                <option value="yes"><?= lang('system.system_yes') ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamically Generated Custom Fields -->
                    <?php foreach ($customFields as $field): ?>
                        <div class="form-group">
                            <label for="<?= $field['name'] ?>"><?= ucfirst($field['name']) ?></label>
                            <input type="<?= $field['type'] ?>"
                                name="custom_fields[<?= $field['id'] ?>]"
                                id="<?= $field['name'] ?>"
                                value="<?= $customValues[$field['id']] ?? '' ?>"
                                class="form-control">
                        </div>
                    <?php endforeach; ?>

                </form>
            </div>
        </div>
    </div>
</div>