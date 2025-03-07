<?php if ($customFields): ?>
    <?php foreach ($customFields as $field): ?>
        <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
            <label class="control-label col-xs-4"
                for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
            <div class="col-xs-6">
                <?php if ($field['options'] != "") { ?>
                    <select class="form-control" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>">
                        <option value="">Select Option</option>
                        <?php
                        foreach (explode("\r\n", $field['options']) as $option) {
                            ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]"
                        id="<?= $field['field_name']; ?>" class="form-control" />
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>