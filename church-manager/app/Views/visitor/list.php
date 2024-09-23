<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('visitors','add', '<?= $parent_id; ?>')">
            <?= lang('visitor.add_visitor'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped scrollable-x-datatable">
            <thead>
                <tr>
                    <th><?= lang('visitor.visitor_action') ?></th>
                    <th><?= lang('visitor.visitor_first_name') ?></th>
                    <th><?= lang('visitor.visitor_last_name') ?></th>
                    <th><?= lang('visitor.visitor_phone') ?></th>
                    <th><?= lang('visitor.visitor_email') ?></th>
                    <th><?= lang('visitor.visitor_gender') ?></th>
                    <th><?= lang('visitor.visitor_date_of_birth') ?></th>
                    <th><?= lang('visitor.visitor_payment_id') ?></th>
                    <th><?= lang('visitor.visitor_payment_code') ?></th>
                    <th><?= lang('visitor.visitor_registration_amount') ?></th>
                    <th><?= lang('visitor.visitor_status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $visitor) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $visitor['first_name']; ?> visitor">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($visitor['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $visitor['first_name']; ?> visitor">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($visitor['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($visitor['id']); ?>')" title="Delete <?= $visitor['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $visitor['first_name']; ?></td>
                        <td><?= $visitor['last_name']; ?></td>
                        <td><?= $visitor['phone']; ?></td>
                        <td><?= $visitor['email']; ?></td>
                        <td><?= $visitor['gender']; ?></td>
                        <td><?= $visitor['date_of_birth']; ?></td>
                        <td><?= $visitor['payment_id']; ?></td>
                        <td><?= $visitor['payment_code']; ?></td>
                        <td><?= $visitor['registration_amount']; ?></td>
                        <td><?= $visitor['status']; ?></td>

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
        }]
    })
</script>