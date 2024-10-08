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
                        <i class='fa fa-eye'></i><?= lang('report.view_report'); ?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active"><a href="#view_report" id="view_report_tab" data-toggle="tab"><?= lang('report.view_report'); ?></a></li>
                            <li><a href="#view_section_a" data-item_id="<?= $id; ?>" data-link_id="view_section_a" onclick="loadSection(this)" id="view_section_a_tab" data-toggle="tab"><?= lang('report.section_A'); ?></a></li>
                            <li><a href="#view_section_b" data-item_id="<?= $id; ?>" data-link_id="view_section_b" onclick="loadSection(this)" id="view_section_b_tab" data-toggle="tab"><?= lang('report.section_B'); ?></a></li>
                            <li><a href="#view_section_c" data-item_id="<?= $id; ?>" data-link_id="view_section_c" onclick="loadSection(this)" id="view_section_c_tab" data-toggle="tab"><?= lang('report.section_C'); ?></a></li>
                            <li><a href="#view_section_d" data-item_id="<?= $id; ?>" data-link_id="view_section_d" onclick="loadSection(this)" id="view_section_d_tab" data-toggle="tab"><?= lang('report.section_D'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_report">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $report => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($report); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= ucwords($field_value); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>

                    <!-- These divs will be dynamically filled with content via AJAX -->
                    <div class="tab-pane" id="view_section_a"></div>
                    <div class="tab-pane" id="view_section_b"></div>
                    <div class="tab-pane" id="view_section_c"></div>
                    <div class="tab-pane" id="view_section_d"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function loadSection(tab) {
        var sectionId = $(tab).data('link_id');
        // var itemId = $(tab).data('item_id');
        var url = "<?= site_url('reports/load_section'); ?>/" + sectionId;

        $.ajax({
            url: url,
            type: 'GET',
            // beforeSend: function() {
            //     $("#" + sectionId).html('<div class="loading">Loading...</div>');
            // },
            success: function(data) {
                $("#" + sectionId).html(data);
            },
            error: function(xhr, status, error) {
                $("#" + sectionId).html('<div class="error">Error loading content</div>');
            }
        });
    }

    $(document).ready(function() {
        $('#view_report_tab').trigger('click');
    });
</script>