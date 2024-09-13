<?php
$numeric_assembly_id = hash_id($designation_id, 'decode');
$numeric_designation_id = hash_id($designation_id, 'decode');
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
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('minister.minister_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?= $result['name']; ?>" id="name"
                                placeholder="Edit Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="number">
                            <?= lang('minister.minister_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="number" id="number" value="<?= $result['number']; ?>"
                                placeholder="Edit Number">
                        </div>
                    </div>

                    <?php if (!$numeric_assembly_id) { ?>
                        <div class='form-group'>
                            <label for="assembly_id" class="control-label col-xs-4"><?= lang('minister.minister_assembly_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="assembly_id" id="assembly_id">
                                    <option value="<?= $result['assembly_id'] ?>"><?= $result['assembly_id'] ?></option>
                                    <?php foreach ($assemblies as $assembly) : ?>
                                        <option value="<?php echo $assembly['id']; ?>"><?php echo $assembly['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="assembly_id" id="assembly_id" value="<?= $assembly_id; ?>" />
                    <?php } ?>

                    <?php if (!$numeric_designation_id) { ?>
                        <div class='form-group'>
                            <label for="designation_id" class="control-label col-xs-4"><?= lang('minister.minister_designation_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="designation_id" id="designation_id">
                                    <option value="<?= $result['designation_id'] ?>"><?= $result['designation_id'] ?></option>
                                    <?php foreach ($designations as $designation) : ?>
                                        <option value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="designation_id" id="designation_id" value="<?= $designation_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">
                            <?= lang('minister.minister_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="phone" id="phone" value="<?= $result['phone']; ?>"
                                placeholder="Edit Phone">
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
                </form>
            </div>
        </div>
    </div>
</div>