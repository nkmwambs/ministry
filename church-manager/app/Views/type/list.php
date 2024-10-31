<?=button_row($feature, $parent_id)?>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><?= lang('type.type_action') ?></th>
                    <th><?= lang('type.type_name') ?></th>
                    <th><?= lang('type.type_code') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $type) { ?>
                    <tr>
                        <td>
                        <span class='action-icons' title="View <?= singular($type['name']); ?> type">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?= plural($feature); ?>','view', '<?= hash_id($type['id']); ?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $type['id']; ?> designation">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($type['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($type['id']); ?>')" title="Delete <?= $type['id']; ?> type"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $type['name']; ?></td>
                        <td><?= $type['type_code']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>