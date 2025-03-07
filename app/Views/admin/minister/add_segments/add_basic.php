<?php
$numeric_assembly_id = hash_id($assembly_id, 'decode');
$numeric_member_id = hash_id($member_id, 'decode');
?>

<?php if (!$numeric_assembly_id) { ?>
    <div class='form-group'>
        <label for="assembly_id" class="control-label col-xs-4"><?= lang('minister.minister_assembly_id') ?></label>
        <div class="col-xs-6">
            <select class="form-control" name="assembly_id" id="assembly_id">
                <option value=""><?= lang('minister.select_assembly') ?></option>
                <?php foreach ($assemblies as $assembly): ?>
                    <option value="<?php echo $assembly['id']; ?>"><?php echo $assembly['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php } else { ?>
    <input type="hidden" name="assembly_id" id="assembly_id" value="<?= $assembly_id; ?>" />
<?php } ?>

<?php if (!$numeric_member_id) { ?>
    <div class='form-group'>
        <label for="member_id" class="control-label col-xs-4"><?= lang('minister.minister_member_id') ?></label>
        <div class="col-xs-6">
            <select class="form-control" name="member_id" id="member_id">
                <option value=""><?= lang('minister.select_member') ?></option>

            </select>
        </div>
    </div>
<?php } else { ?>
    <input type="hidden" name="member_id" id="member_id" value="<?= $member_id; ?>" />
<?php } ?>

<div class='form-group'>
    <label for="license_number" class="control-label col-xs-4"><?= lang('minister.license_number') ?></label>
    <div class="col-xs-6">
        <input type="text" class="form-control" name="license_number" id="license_number"
            placeholder="<?= lang('minister.enter_license_number'); ?>" />
    </div>
</div>