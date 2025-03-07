<?php if (!empty($customFields)) { ?>
    <div class="tab-pane" id="<?=$tab_pane_id;?>" role="tabpanel">
        <?php
        foreach ($customFields as $field):
            echo view_cell(
                'CustomFormFieldCell',
                [
                    'field_code' => $field['field_code'],
                    'field_name' => $field['field_name'],
                    'values' => $customValues,
                    'form_values' => $customValues,
                    'field_type' => $field['type'],
                    'field_id' => $field['id'],
                    'field_options' => $field['options'],
                ]
            );
        endforeach;
        ?>
    </div>
<?php } ?>