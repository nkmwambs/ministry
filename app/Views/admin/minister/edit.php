<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i>
                        <?= lang('minister.edit_minister') ?>
                    </div>

                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item active"><a class="nav-link" href="#edit_minister_basic"
                                    id="edit_minister_tab_basic"
                                    data-toggle="tab"><?= lang('minister.edit_minister_basic') ?></a></li>
                            <?php if (!empty($customFields)) { ?>
                                <li class="nav-item"><a class="nav-link" href="#edit_minister_additional"
                                        id="edit_minister_tab_additional"
                                        data-toggle="tab"><?= lang('minister.edit_minister_additional') ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_minister" method="post" action="<?= site_url('ministers/update/'); ?>" role="form"
                    class="form-horizontal form-groups-bordered">

                    <div class="tab-content">
                        <div class="tab-pane active" id="edit_minister_basic" role="tabpanel">
                            <input type="hidden" name="minister_id" value="<?= hash_id($result['id']); ?>" />
                            <input type="hidden" name="member_id"
                                value="<?= hash_id($minister['member_id'], 'encode'); ?>" />

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
                                    <input type="text" class="form-control" name="member_first_name"
                                        value="<?= $result['member_first_name']; ?>" id="member_first_name"
                                        placeholder="<?= lang('minister.edit_member_first_name'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="member_last_name">
                                    <?= lang('minister.member_last_name') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="member_last_name"
                                        value="<?= $result['member_last_name']; ?>" id="member_last_name"
                                        placeholder="<?= lang('minister.edit_member_last_name'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="license_number">
                                    <?= lang('minister.license_number') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="license_number"
                                        value="<?= $result['license_number']; ?>" id="license_number"
                                        placeholder="<?= lang('minister.license_number'); ?>">
                                </div>
                            </div>

                            <div class='form-group'>
                                <label for="assembly_id"
                                    class="control-label col-xs-4"><?= lang('minister.minister_assembly_id') ?></label>
                                <div class="col-xs-6">
                                    <select class="form-control" name="assembly_id" id="assembly_id">
                                        <option value=""><?= lang('minister.select_assembly'); ?></option>
                                        <?php foreach ($assemblies as $assembly) { ?>
                                            <option value="<?= $assembly['id']; ?>"
                                                <?= $result['assembly_id'] == $assembly['id'] ? 'selected' : ''; ?>>
                                                <?= $assembly['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label for="designation_id"
                                    class="control-label col-xs-4"><?= lang('minister.minister_designation_id') ?></label>
                                <div class="col-xs-6">
                                    <select class="form-control" name="designation_id" id="designation_id">
                                        <option value=""><?= lang('minister.select_designation'); ?></option>
                                        <?php foreach ($designations as $designation) { ?>
                                            <option value="<?= $designation['id']; ?>"
                                                <?= $result['designation_id'] == $designation['id'] ? 'selected' : ''; ?>>
                                                <?= $designation['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="member_phone">
                                    <?= lang('minister.member_phone') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="member_phone" id="member_phone"
                                        value="<?= $result['member_phone']; ?>"
                                        placeholder="<?= lang('minister.edit_phone'); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="is_active">
                                    <?= lang('minister.minister_is_active') ?>
                                </label>
                                <div class="col-xs-6">
                                    <select class="form-control" name="is_active" id="is_active">
                                        <option value=""><?= lang('minister.select_status'); ?></option>
                                        <option value="yes" <?= $result['is_active'] == 'yes' ? 'selected' : ''; ?>>
                                            <?= lang('system.system_yes'); ?></option>
                                        <option value="no" <?= $result['is_active'] == 'no' ? 'selected' : ''; ?>>
                                            <?= lang('system.system_no'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamically generated custom fields -->

                        <?php
                        $tab_pane_id = "edit_minister_additional";
                        ?>
                        <?= view_cell('CustomEditTabPaneCell', compact('customFields', 'customValues', 'tab_pane_id')); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>