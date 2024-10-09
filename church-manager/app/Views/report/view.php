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
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Saved</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">133</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Sanctified</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">67</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number filled with Holy Ghost</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number Baptised of Water</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Member Transferred Away</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Member Transferred In</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Deceased</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Added</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Excluded</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Average Sunday School Attendance</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Weekly Attenders</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Proportion od Children and Youth Attenders</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Enclosed Any News to Share?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Department of Pastoral Care</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Youth Ministries</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Children Ministries</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Sunday School (Christian Education)</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Women Ministries</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">First Sunday Offering</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Second Sunday Missions</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Fourth Sunday</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Revival This Month</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Bible Study/Training Programmes this month</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                        </form>
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
        // Load section A content via AJAX
        $('#view_section_a_tab').on('shown.bs.tab', function(e) {
            $.ajax({
                url: '<?= site_url('path_to_section_a_view') ?>',
                method: 'GET',
                success: function(response) {
                    $('#view_section_a').html(response);
                }
            });
        });

        // Similarly, you can add AJAX handlers for other tabs if needed
    });
</script>