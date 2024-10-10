<?php
// echo json_encode($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("reports"); ?>" class="btn btn-info">Back</a>
    </div>
</div>

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
                            <li class="active"><a href="#view_report" id="view_report_tab" data-toggle="tab"><?= lang('report.edit_report'); ?></a></li>
                            <li><a href="#view_section_a" data-item_id="<?= $id; ?>" data-link_id="view_section_a" onclick="childrenAjaxLists(this)" id="view_section_a_tab" data-toggle="tab"><?= lang('report.section_A'); ?></a></li>
                            <li><a href="#view_section_a" data-item_id="<?= $id; ?>" data-link_id="view_section_b" onclick="childrenAjaxLists(this)" id="view_section_b_tab" data-toggle="tab"><?= lang('report.section_B'); ?></a></li>
                            <li><a href="#view_section_c" data-item_id="<?= $id; ?>" data-link_id="view_section_c" onclick="childrenAjaxLists(this)" id="view_section_c_tab" data-toggle="tab"><?= lang('report.section_C'); ?></a></li>
                            <li><a href="#view_section_d" data-item_id="<?= $id; ?>" data-link_id="view_section_d" onclick="childrenAjaxLists(this)" id="view_section_d_tab" data-toggle="tab"><?= lang('report.section_D'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_report">
                        <form id="frm_edit_report" method="post" action="<?= site_url('reports/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">
                            <div class="form-group">
                                <label class="control-label col-xs-4" for="reports_type_id">
                                    <?= lang('meeting.meeting_name') ?>
                                </label>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="reports_type_id" id="reports_type_id" value="<?= $result['reports_type_id']; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-4" for="report_period">
                                    <?= lang('meeting.meeting_description') ?>
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

                    <div class="tab-pane" id="view_section_a">
                        <div class='info'><?= lang('report.section_A') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_b">
                        <div class='info'><?= lang('report.section_B') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_s">
                        <div class='info'><?= lang('report.section_C') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_d">
                        <div class='info'><?= lang('report.section_D') ?></div>
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