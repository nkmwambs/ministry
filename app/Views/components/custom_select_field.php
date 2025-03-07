<div class="form-group" id="<?= $field_code; ?>">
    <label class="control-label col-xs-4" for="<?= $field_name ?>"><?= ucfirst($field_name) ?></label>
    <div class="col-xs-6">
        <select name="custom_fields[<?= $field_id;?>]" id="<?= $field_name;?>" class="form-control">
            <?php foreach($field_options as $option){?>
                <option value="<?php echo strtolower($option);?>" <?php echo (strtolower($field_value) == strtolower($option))?'selected':'';?>><?php echo humanize($option);?></option>
            <?php }?>
        </select>
    </div>
</div>