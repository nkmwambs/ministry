<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('denomination.list_denominations'); ?>
        </div>
    </div>
</div>

<?=button_row($feature)?>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'></div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('denomination.denomination_action') ?></th>
                    <th><?= lang('denomination.denomination_name') ?></th>
                    <th><?= lang('denomination.denomination_code') ?></th>
                    <th><?= lang('denomination.denomination_registration_date') ?></th>
                    <th><?= lang('denomination.denomination_email') ?></th>
                    <th><?= lang('denomination.denomination_phone') ?></th>
                    <th><?= lang('denomination.denomination_head_office') ?></th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated by DataTables -->
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function (){
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('denominations/fetchDenominations')?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="<?= site_url(service('session')->user_type."/denominations/view/") ?>' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' participant"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "name" },
            { data: "code" },
            { data: "registration_date" },
            { data: "email" },
            { data: "phone" },
            { data: "head_office" }
        ]
    });
});
</script>
