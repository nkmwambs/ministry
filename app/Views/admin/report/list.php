<?php 
// echo json_encode($parent_id);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('report.list_reports'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('report.report_action') ?></th>
                    <th><?= lang('report.report_denomination_id') ?></th>
                    <th><?= lang('report.report_assembly_id') ?></th>
                    <th><?= lang('report.report_type_id') ?></th>
                    <th><?= lang('report.report_period') ?></th>
                    <th><?= lang('report.report_date') ?></th>
                    <th><?= lang('report.report_status') ?></th>
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
            "url": "<?php echo site_url('reports/fetchReports')?>",
            "type": "POST",
            data: function (d){
                d.reportTypeId = '<?=$parent_id;?>'
            }
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="' + base_url + 'reports/view/' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' report"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "denomination_name" },
            { data: "assembly_name" },
            { data: "reporttype_name" },
            { data: "report_period" },
            { data: "report_date" },
            { data: "status" }
        ]
    });
});
</script>