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
                        <?= lang('minister.edit_minister') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_minister" method="post" action="<?= site_url('ministers/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

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

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_first_name">
                            <?= lang('minister.member_first_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?= $result['member_first_name']; ?>" id="member_first_name"
                                placeholder="<?=lang('minister.edit_member_first_name');?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_last_name">
                            <?= lang('minister.member_last_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="member_last_name" value="<?= $result['member_last_name']; ?>" id="member_last_name"
                                placeholder="<?=lang('minister.edit_member_last_name');?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="license_number">
                            <?= lang('minister.license_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="license_number" value="<?= $result['license_number']; ?>" id="license_number"
                                placeholder="<?=lang('minister.edit_license_number');?>">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="assembly_id" class="control-label col-xs-4"><?= lang('minister.minister_assembly_id') ?></label>
                        <div class="col-xs-6">
                            <select class="form-control" name="assembly_id" id="assembly_id">
                                <option value="<?= $result['assembly_id'] ?>"><?= $result['assembly_id'] ?></option>

                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for="designation_id" class="control-label col-xs-4"><?= lang('minister.minister_designation_id') ?></label>
                        <div class="col-xs-6">
                            <select class="form-control" name="designation_id" id="designation_id">
                                <option value="<?= $result['designation_id'] ?>"><?= $result['designation_id'] ?></option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_phone">
                            <?= lang('minister.member_phone') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="member_phone" id="member_phone" value="<?= $result['member_phone']; ?>"
                                placeholder="<?=lang('minister.edit_phone');?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_active">
                            <?= lang('minister.minister_is_active') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="is_active" id="is_active" value="<?= $result['is_active']; ?>"
                                placeholder="Edit Active Status">
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