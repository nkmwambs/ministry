<table class = 'table table-striped'>
    <thead>
        <tr>
            <th><?=lang("type.field_name")?></th>
            <th><?=lang("type.field_type")?></th>
            <th><?=lang("type.field_option")?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($part_fields as $customFieldId){
                echo custom_field_row($customFieldId);
            }
        ?>
    </tbody>
</table>