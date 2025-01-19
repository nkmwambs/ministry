<?php 
// echo $parent_id;
?>

<?=button_row($feature, $parent_id)?>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped scrollable-x-datatable">
            <thead>
                <tr>
                    <th><?= lang('collection.collection_action') ?></th>
                    <th><?= lang('collection.collection_return_date') ?></th>
                    <th><?= lang('collection.collection_revenue_id') ?></th>
                    <th><?= lang('collection.collection_amount') ?></th>
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
                        <td><?= $collection['revenue_name']; ?></td>
                        <td><?= $collection['amount']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('.scrollable-x-datatable').DataTable({
        stateSave: true,
        scrollX: true,
        scrollY: 200,
        scrollCollapse: true,
        fixedColumns: true,
        fixedHeader: true,
        responsive: true,
        // dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        // deferLoading: true,
        // processing: true,
        // serverSide: true,
        // "ajax": {
        //     'url': "<?=site_url();?>/api/users/getAll",
        //     "method": "POST"
        // },
        // "columns": [
        //     { "data": "id" },
        //     { "data": "name" },
        //     { "data": "email" }
        // ]
    })
</script>