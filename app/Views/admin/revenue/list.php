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
                    <th><?= lang('revenue.revenue_action') ?></th>
                    <th><?= lang('revenue.revenue_name') ?></th>
                    <th><?= lang('revenue.revenue_description') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $revenue) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $revenue['id']; ?> revenue">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($revenue['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $revenue['id']; ?> revenue">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($revenue['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($revenue['id']); ?>')" title="Delete <?= $revenue['id']; ?> revenue"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $revenue['name']; ?></td>
                        <td><?= $revenue['description']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>