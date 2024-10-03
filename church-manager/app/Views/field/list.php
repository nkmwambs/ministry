<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?= plural($feature); ?>','add')">
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
                            <span class='action-icons' title="View <?= $customField['id']; ?> custom field">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($customField['id']);?>')"></i>
                            </span>
                            <span class='action-icons'>
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($customField['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($customField['id']); ?>')" title="Delete <?= $customField['id']; ?> participant"><i class='fa fa-trash'></i></span>
                        </td>

                        <td><?= $customField['name']; ?></td>
                        <td><?= $customField['type']; ?></td>
                        <td><?= $customField['options']; ?></td>
                        <td><?= $customField['feature_id']; ?></td>
                        <td><?= $customField['field_order']; ?></td>
                        <td><?= $customField['visible']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>