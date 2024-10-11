<style>
    .center,
    .heading {
        text-align: center;
        padding-bottom: 20px;
    }

    .heading {
        padding-top: 20px;
        font-weight: bold;
    }

    .minister_checkbox {
        text-align: center;
        padding-top: 20px;
    }
</style>

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
                        <div class="row">
                            <div class="col-xs-12 center heading">
                                PART 1: PASTOR'S LOCAL CHURCH REPORT
                            </div>
                        </div>

                        <form class="form-horizontal form-groups-bordered" role="form">

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Name of Church</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Anglican Church of Kenya</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">District</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Kilifi District</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Address</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Mombasa - Malindi Street</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Saved</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of Sanctified</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">123</div>
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

                            <!-- <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div>  -->
                        </form>
                    </div>

                    <div class="tab-pane" id="view_section_b">
                        <div class="row">
                            <div class="col-xs-12 center heading">
                                PART 2: TREASURER'S FINANCIAL REPORT
                            </div>
                        </div>

                        <form class="form-horizontal form-groups-bordered" role="form">

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Treasurer Name</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Jimmy Kafangi</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Phone</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">+254178299300</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Tithes from Local Church</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">200,000</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 center heading">
                                    SECTION ONE: Report to National Office
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">10% total Tithes to National Office</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Revival This Month</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Harvest and Leadership Development Offering</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">100,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Fourth Sunday</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Other Monies sent to National Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">50,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Amount of Section One sent to National Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 center heading">
                                    SECTION TWO: Report to International Office
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">10% total Tithes to International Office</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">15,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Second Sunday</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Other Monies sent to International Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">15,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Amount of Section Two sent to International Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">30,000</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Add divs for other sections as needed -->
                    <div class="tab-pane" id="view_section_c">
                        <div class="row">
                            <div class="col-xs-12 center heading">
                                PART 3: MINISTER'S REPORT
                            </div>
                        </div>

                        <form class="form-horizontal form-groups-bordered" role="form">
                            <div class="form-group">
                                <div class="column minister_checkbox">
                                    <label class="switcher">
                                        <span class="switcher-label">Licence held</span>
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                    </label>
                                    <!-- </div> -->
                                    <!-- <div class="column"> -->
                                    <label class="switcher">
                                        <span class="switcher-label">Bishop</span>
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                    </label>
                                    <!-- </div> -->
                                    <!-- <div class="column"> -->
                                    <label class="switcher">
                                        <span class="switcher-label">Evangelist</span>
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                    </label>
                                    <!-- </div> -->
                                    <!-- <div class="column"> -->
                                    <label class="switcher">
                                        <span class="switcher-label">Lay Minister</span>
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Sermons</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Converted</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">300</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Sanctified</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">200</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Baptised</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Received Holy Ghost</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">31</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Added to Church</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">10</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Fourth Sunday</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Preayer Meeting</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">5</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Homes Visited</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Tithes Paid to Local Church</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">15,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">First Sunday Offering Received</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Other Offering Received</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">15,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Your Expenses in Ministry</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">30,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Amount of this Section sent to International Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Do you boost the general assembly's recommendations?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of revivals conducted this month?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">30</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of revivals conducted this week?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">7</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of revivals conducted in weekdays?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">7</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Where did you conduct this</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Lamu</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Are you full time minister?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">Yes</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Number of new home prayer meeting conducted by you?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">5</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Do you have daily family workship?</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">No</div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="tab-pane" id="view_section_d">
                        <div class="row">
                            <div class="col-xs-12 center heading">
                                PART 4: CALCULATIONS
                            </div>
                        </div>

                        <form class="form-horizontal form-groups-bordered" role="form">

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Amount sent to National Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Total Amount sent to International Treasurer</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">30,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Minister's Tithe to National office and Minister's Care Fund</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">200,000</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label col-xs-4">Others (specify)</label>
                                <div class="col-xs-6">
                                    <div class="form_view_field">20,000</div>
                                </div>
                            </div>

                        </form>
                    </div>

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