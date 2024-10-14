<?php
// echo json_encode($result);
?>

<div class="row">
    <?php if (session()->getFlashdata('message')) { ?>
        <div class="col-xs-12 info">
            <p><?= session()->getFlashdata('message'); ?></p>
            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>"><?= lang('report.edit_again_button'); ?></a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('report.edit_report'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active">
                                <a href="#edit_report" id="edit_report_tab" data-toggle="tab"><?= lang('report.edit_report'); ?></a>
                            </li>
                            <li>
                                <a href="#edit_section_a" id="edit_section_a_tab" data-toggle="tab"><?= lang('report.section_A'); ?></a>
                            </li>
                            <li>
                                <a href="#edit_section_b" id="edit_section_b_tab" data-toggle="tab"><?= lang('report.section_B'); ?></a>
                            </li>
                            <li>
                                <a href="#edit_section_c" id="edit_section_c_tab" data-toggle="tab"><?= lang('report.section_C'); ?></a>
                            </li>
                            <li>
                                <a href="#edit_section_d" id="edit_section_d_tab" data-toggle="tab"><?= lang('report.section_D'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="edit_report">
                        <form id="frm_edit_report" method="post" action="<?= site_url('reports/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">
                            <div class="form-group">
                                <label class="control-label col-xs-4" for="reports_type_id">
                                    <?= lang('report.report_type_id') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="reports_type_id" id="reports_type_id" value="<?= $result['reports_type_id']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="report_period">
                                    <?= lang('report.report_period') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control datepicker" name="report_period" id="report_period" value="<?= $result['report_period']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="report_date">
                                    <?= lang("report.report_date") ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control datepicker" name="report_date" id="report_date" value="<?= $result['report_date']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="status">
                                    <?= lang('report.report_status') ?>
                                </label>
                                <div class="col-xs-6">
                                    <select type="text" class="form-control" name="status" id="status">
                                        <option value="<?= $result['status']; ?>"><?= ucfirst($result['status']); ?></option>
                                        <option value="draft"><?= lang('system.system_draft') ?></option>
                                        <option value="submitted"><?= lang('system.system_submitted') ?></option>
                                        <option value="approved"><?= lang('system.system_approved') ?></option>
                                    </select>
                                </div>
                            </div>

                            <?php foreach ($customFields as $field): ?>
                                <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                                    <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
                                    <div class="col-xs-6">
                                        <input type="<?= $field['type'] ?>"
                                            name="custom_fields[<?= $field['id'] ?>]"
                                            id="<?= $field['field_name'] ?>"
                                            value="<?= $customValues['value'] ?? '' ?>"
                                            class="form-control">
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div>  -->
                        </form>
                    </div>

                    <div class="tab-pane" id="edit_section_a">
                        <form id="frm_edit_section_a" method="post" action="<?= site_url('reports/sections/a/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                        </form>
                    </div>

                    <div class="tab-pane" id="edit_section_b">
                        <form id="frm_edit_section_b" method="post" action="<?= site_url('reports/sections/b/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                        </form>
                    </div>

                    <div class="tab-pane" id="edit_section_c">
                        <form id="frm_edit_section_c" method="post" action="<?= site_url('reports/sections/c/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                        </form>
                    </div>

                    <div class="tab-pane" id="edit_section_d">
                        <form id="frm_edit_section_d" method="post" action="<?= site_url('reports/sections/d/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('.list-group-item:first').trigger('click');
    // })

    // $('.list-group-item-action').on('click', function (ev){
    //    const url = "<?= site_url("reports") ?>"

    //    $.ajax({
    //     url: url + '/' + $(this).data('section') + '/<?= $id; ?>',
    //     type: 'GET',
    //     beforeSend: function(){
    //         $("#overlay").css("display", "block");
    //     },
    //     success: function (data) {
    //         $('#section_data').html(data);
    //         $("#overlay").css("display", "none");
    //     },
    //     error: function(xhr, status, error) {
    //         $('#section_data').html('<div class="error">Error Occurred</div>');
    //         $("#overlay").css("display", "none");
    //     }
    //    })

    //    ev.preventDefault()
    // })
</script>