<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('collections','add', '<?= $parent_id; ?>')">
            <?= lang('collection.add_collection'); ?>
        </div>
    </div>
</div>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><?= lang('collection.collection_action') ?></th>
                    <th><?= lang('collection.collection_return_date') ?></th>
                    <th><?= lang('collection.collection_period_start_date') ?></th>
                    <th><?= lang('collection.collection_period_end_date') ?></th>
                    <th><?= lang('collection.collection_revenue_id') ?></th>
                    <th><?= lang('collection.collection_amount') ?></th>
                    <th><?= lang('collection.collection_status') ?></th>
                    <th><?= lang('collection.collection_collection_reference') ?></th>
                    <th><?= lang('collection.collection_description') ?></th>
                    <th><?= lang('collection.collection_collection_method') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $collection) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= hash_id($collection['id']); ?> collection">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($collection['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= hash_id($collection['id']); ?> collection">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($collection['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($collection['id']); ?>')" title="Delete <?= $collection['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $collection['return_date']; ?></td>
                        <td><?= $collection['period_start_date']; ?></td>
                        <td><?= $collection['period_end_date']; ?></td>
                        <td><?= $collection['revenue_id']; ?></td>
                        <td><?= $collection['amount']; ?></td>
                        <td><?= $collection['status']; ?></td>
                        <td><?= $collection['collection_reference']; ?></td>
                        <td><?= $collection['description']; ?></td>
                        <td><?= $collection['collection_method']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>