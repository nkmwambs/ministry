<div class="form-group" id="<?= $field_code; ?>">
    <label class="control-label col-xs-4" for="<?= $field_name ?>"><?= ucfirst($field_name) ?></label>
    <div class="col-xs-6">
        <input type="<?= $field_type; ?>" name="custom_fields[<?= $field_id;?>]" id="<?= $field_name;?>"
            value="<?= $field_value; ?>" class="form-control">
    </div>
</div>