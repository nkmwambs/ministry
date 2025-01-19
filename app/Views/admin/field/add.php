<?php
$numeric_denomination_id = hash_id($parent_id, 'decode');
$numeric_feature_id = hash_id($feature_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-plus-circle'></i>
                        <?= lang('field.add_customfield') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_customfield" method="post" action="<?= site_url("fields/save") ?>" class="form-horizontal form-groups-bordered">

                    <!-- <?php if (session()->get('errors')): ?>
                        <div class="form-group">
                            <div class="col-xs-12 error">
                                <ul>
                                    <?php foreach (session()->get('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?> -->

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (!$numeric_denomination_id) { ?>
                        <div class='form-group'>
                            <label for="denomination_id" class="control-label col-xs-4"><?= lang('event.event_denomination_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="denomination_id" id="denomination_id">
                                    <option value=""><?= lang('event.select_denomination') ?></option>
                                    <?php foreach ($denominations as $denomination) : ?>
                                        <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
                    <?php } ?>

                    <?php if (!$numeric_feature_id) { ?>
                        <div class='form-group'>
                            <label for="feature_id" class="control-label col-xs-4"><?= lang('field.customfield_feature_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control select_fields" name="feature_id" id="feature_id">
                                    <option value=""><?= lang('field.select_feature') ?></option>
                                    <?php foreach ($features as $designation) : ?>
                                        <option value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="feature_id" id="feature_id" value="<?= $feature_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="field_name">
                            <?= lang("field.customfield_name") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="field_name" id="field_name" placeholder="<?= lang('system.system_enter_name') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="helptip">
                            <?= lang("field.customfield_helptip") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="helptip" id="helptip" placeholder="<?= lang('field.enter_helptip') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="field_code">
                            <?= lang("field.customfield_code") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="field_code" id="field_code" placeholder="<?= lang('field.enter_code') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="type">
                            <?= lang("field.customfield_type") ?>
                        </label>
                        <div class="col-xs-6">
                            <select name="type" id="type" class="form-control" required>
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

                    <div class="form-group hidden" id = "form_group_options">
                        <label class="control-label col-xs-4" for="options">
                            <?= lang("field.customfield_options") ?>
                        </label>
                        <div class="col-xs-6">
                            <textarea type="text" class="form-control" name="options" id="options" placeholder="<?=lang('field.enter_options');?>"></textarea>
                        </div>
                    </div>

                    <div class="form-group hidden" id = "form_group_builder">
                        <label class="control-label col-xs-4" for="code_builder">
                            <?= lang("field.customfield_sql_builder") ?>
                        </label>
                        <div class="col-xs-6">
                            <textarea type="text" class="form-control" name="code_builder" id="code_builder" placeholder="<?=lang('field.enter_sql_query');?>"></textarea>
                        </div>
                    </div>

                    <!-- Dynamically Generated Custom Fields -->
                    <?php foreach ($customFields as $field): ?>
                        <div class="form-group custom_field_container hidden" id="<?= $field['visible']; ?>">
                            <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
                            <div class="col-xs-6">
                                <input type="<?= $field['field_type'] ?>" name="custom_fields[<?= $field['id'] ?>]" id="<?= $field['field_name'] ?>" class="form-control">
                            </div>
                        </div>
                    <?php endforeach; ?>

                </form>

            </div>

        </div>

    </div>
</div>

<script>
$("#feature_id").on("change", function(){
    const parent_id = $(this).val();
    const form_groups = $('.content');
   
    if(parent_id > 0){
      form_groups.filter('#table_name').attr('disabled','disabled');
    }
})

$(document).on("change","#type", function(){
    const field_type = $(this).val();
    const form_group_options = $("#form_group_options");

    form_group_options.addClass('hidden');
    form_group_options.find("#options").val("");

    if(field_type == 'dropdown' || field_type == 'boolean'){
        form_group_options.removeClass('hidden');
    }
});

$(document).on('change',"#feature_id", function(){
    const feature_id = $(this).val();
    const form_group_builder = $("#form_group_builder");

    form_group_builder.addClass('hidden');
    form_group_builder.find("#code_builder").val("");

    if(feature_id == 18){
        form_group_builder.removeClass('hidden');
    }
})
</script>