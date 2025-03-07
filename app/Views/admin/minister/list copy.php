<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('minister.list_ministers'); ?>
        </div>
    </div>
</div>

<?=button_row($feature)?>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped" id="dataTable">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('minister.minister_action_col') ?></th>
                    <th><?= lang('minister.minister_number') ?></th>
                    <th><?= lang('minister.member_first_name') ?></th>
                    <th><?= lang('minister.member_last_name') ?></th>
                    <th><?= lang('minister.license_number') ?></th>
                    <th><?= lang('minister.member_designation') ?></th>
                    <th><?= lang('minister.member_phone') ?></th>
                    <th><?= lang('minister.minister_assembly_id') ?></th>
                    <th><?= lang('minister.minister_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
                
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
            "url": "<?php echo site_url('ministers/fetchMinisters')?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="' + base_url + 'ministers/view/' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' minister"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "minister_number" },
            { data: "member_first_name" },
            { data: "member_last_name" },
            { data: "license_number" },
            { data: "designation_name" },
            { data: "member_phone" },
            { data: "assembly_name" },
            { data: "is_active" },
        ]
    });
});
</script>