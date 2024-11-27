<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('designation.view_designation'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active"><a href="#view_minister" id="view_designation_tab" data-toggle="tab"><?= lang('designation.view_designation'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_designation">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $department => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($department); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- <div class="form-group">
                                <div class="col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($designation) . '/edit/' . $id) ?>" class="btn btn-primary">
                                        <?= lang('designation.edit_button') ?>
                                    </a>
                                </div>
                            </div> -->
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>