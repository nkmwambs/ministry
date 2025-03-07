<?php
$numeric_designation_id = hash_id($designation_id, 'decode');
?>


<div class="form-group">
    <label class="control-label col-xs-4" for="first_name">
        <?= lang('member.member_first_name') ?>
    </label>
    <div class="col-xs-6">
        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-xs-4" for="last_name">
        <?= lang('member.member_last_name') ?>
    </label>
    <div class="col-xs-6">
        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name">
    </div>
</div>

<div class='form-group'>
    <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_gender') ?></label>
    <div class="col-xs-6">
        <select class="form-control" name="gender" id="gender">
            <option value=""><?= lang('member.member_select_gender') ?></option>
            <option value="male"><?php echo lang('system.gender_male'); ?></option>
            <option value="female"><?php echo lang('system.gender_female'); ?></option>
        </select>
    </div>
</div>

<div class='form-group'>
    <label for="membership_date" class="control-label col-xs-4"><?= lang('member.membership_date') ?></label>
    <div class="col-xs-6">
        <input type="text" class="form-control datepicker" id="membership_date" name="membership_date"
            placeholder="Enter Membership Date" />
    </div>
</div>

<?php
if (isset($parent_id) && hash_id($parent_id, 'decode') > 0) {
    ?>
    <input type="hidden" name="assembly_id" value="<?= $parent_id; ?>" />
    <?php
} else {
    ?>
    <div class="form-group">
        <label class="control-label col-xs-4" for="assembly_id"><?= lang('member.member_assembly_id') ?></label>
        <div class="col-xs-6">
            <select class="form-control" name="assembly_id" id="assembly_id">
                <option value=""><?= lang('assembly.select_assembly') ?></option>
                <?php foreach ($assemblies as $assembly) { ?>
                    <option value="<?= hash_id($assembly['id'], 'encode'); ?>"><?= $assembly['name']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php
}
?>

<?php if (!$numeric_designation_id) { ?>
    <div class='form-group'>
        <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_designation_id') ?></label>
        <div class="col-xs-6">
            <select class="form-control" name="designation_id" id="designation_id">
                <option value=""><?= lang('member.select_designation') ?></option>
                <?php foreach ($designations as $designation): ?>
                    <option value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php } else { ?>
    <input type="hidden" name="designation_id" id="designation_id" value="<?= $parent_id; ?>" />
<?php } ?>

<div class="form-group">
    <label class="control-label col-xs-4" for="date_of_birth">
        <?= lang('member.member_date_of_birth') ?>
    </label>
    <div class="col-xs-6">
        <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth"
            placeholder="Enter Date of Birth"></i>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4" for="email">
        <?= lang('member.member_email') ?>
    </label>
    <div class="col-xs-6">
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email"></i>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4" for="phone">
        <?= lang('member.member_phone') ?>
    </label>
    <div class="col-xs-6">
        <input type="email" class="form-control" name="phone" id="phone" placeholder="Enter Phone"></i>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4" for="saved_date">
        <?= lang('member.saved_date') ?>
    </label>
    <div class="col-xs-6">
        <input type="text" class="form-control datepicker" name="saved_date" id="saved_date"
            placeholder="Enter Saved Date"></i>
    </div>
</div>