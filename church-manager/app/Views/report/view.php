<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("reports"); ?>" class="btn btn-info">
            <?= lang('report.back_button') ?>
        </a>
    </div>
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
                            <li class="active">
                                <a href="#view_report" id="view_report_tab" data-toggle="tab"><?= lang('report.view_report'); ?></a>
                            </li>
                            <li>
                                <a href="#view_section_a" id="view_section_a_tab" data-toggle="tab"><?= lang('report.section_A'); ?></a>
                            </li>
                            <li>
                                <a href="#view_section_b" id="view_section_b_tab" data-toggle="tab"><?= lang('report.section_B'); ?></a>
                            </li>
                            <li>
                                <a href="#view_section_c" id="view_section_c_tab" data-toggle="tab"><?= lang('report.section_C'); ?></a>
                            </li>
                            <li>
                                <a href="#view_section_d" id="view_section_d_tab" data-toggle="tab"><?= lang('report.section_D'); ?></a>
                            </li>
                            <!-- Other tabs go here -->
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">
                    <!-- Static report view section -->
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

                    <!-- Placeholder divs for dynamic sections -->
                    <!-- section_a.php -->
                    <div class="tab-pane" id="view_section_a">

                    </div>

                    <div class="tab-pane" id="view_section_b"></div>
                    <!-- Add divs for other sections as needed -->

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#view_section_a_tab').on('shown.bs.tab', function(e) { // e is defined here
            $.ajax({
                url: '<?= site_url('reports/sections/a') ?>',
                method: 'GET',
                success: function(response) {
                    $('#view_section_a').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('Error loading section A: ', error);
                }
            });
        });
    });
</script>