<?php 
// log_message('error', json_encode($result));
?>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('report.list_reports'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?= plural($feature); ?>','add')">
            <?= lang('report.add_report'); ?>
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
                    <th><?= lang('report.report_action') ?></th>
                    <th><?= lang('report.report_type_id') ?></th>
                    <th><?= lang('report.report_period') ?></th>
                    <th><?= lang('report.report_date') ?></th>
                    <th><?= lang('report.report_status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $report) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $report['id']; ?> report">
                                <a href="<?= site_url("reports/view/" . hash_id($report['id'])); ?>"><i class='fa fa-search'></i></a></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $report['id']; ?> report">
                                <a style="cursor:pointer" href="<?= site_url("reports/edit" . hash_id($report['id'])); ?>"><i class='fa fa-pencil'></i></a>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($report['id']); ?>')" title="Delete <?= $report['id']; ?> report"><i class='fa fa-trash'></i></span>
                        </td>

                        <td><?= $report['reports_type_id']; ?></td>
                        <td><?= $report['report_period']; ?></td>
                        <td><?= $report['report_date']; ?></td>
                        <td><?= $report['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>