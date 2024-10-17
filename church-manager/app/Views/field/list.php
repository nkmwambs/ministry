<?php
// log_message('error', json_encode($result));
?>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('fields','add','<?= plural($parent_id); ?>')">
            <?= lang('field.add_customfield'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><?= lang('field.customfield_action_col') ?></th>
                    <th><?= lang('field.customfield_name') ?></th>
                    <th><?= lang('field.customfield_type') ?></th>
                    <th><?= lang('field.customfield_options') ?></th>
                    <th><?= lang('field.customfield_feature_id') ?></th>
                    <th><?= lang('field.customfield_field_order') ?></th>
                    <th><?= lang('field.customfield_visible') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $customField) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $customField['field_name']; ?> custom field">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($customField['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $customField['field_name']; ?> custom field">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($customField['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($customField['id']); ?>')" title="Delete <?= $customField['field_name']; ?> custom field"><i class='fa fa-trash'></i></span>
                        </td>

                        <td><?= ucfirst($customField['field_name']); ?></td>
                        <td><?= ucfirst($customField['type']); ?></td>
                        <td><?= ucfirst($customField['options']); ?></td>
                        <td><?= ucfirst($customField['feature_name']); ?></td>
                        <td><?= ucfirst($customField['field_order']); ?></td>
                        <td><?= ucfirst($customField['visible']); ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>