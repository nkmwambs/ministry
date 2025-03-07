<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<div class="row">
    <?php if (session()->getFlashdata('message')) { ?>
        <div class="col-xs-12 info">
            <p><?= session()->getFlashdata('message'); ?></p>
            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>"><?= lang('minister.edit_again_button') ?></a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('minister.view_minister'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item active"><a class="nav-link" href="#view_minister_basic" id="view_minister_tab_basic" data-toggle="tab"><?= lang('minister.view_minister_basic'); ?></a></li>
                            <?php if(!empty($custom_data)) { ?>
                                <li class="nav-item"><a class = "nav-link" href="#view_minister_additional" id="view_minister_tab_additional" data-toggle="tab"><?= lang('minister.view_minister_additional'); ?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_minister_basic">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php 
                                foreach ($result as $label => $field_value) { 
                                    if($label == 'id') continue;
                                    if($label == 'member_id') continue;
                                    if($label == 'assembly_id') continue;
                                    if($label == 'designation_id') continue;
                                    if($label == 'inactivation_reason' && !$field_value) continue;
                                ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($label); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>

                    <?php if(!empty($custom_data)) { ?>
                        <div class="tab-pane" id = "view_minister_additional">
                            <form class="form-horizontal form-groups-bordered" role="form">
                                <?php foreach ($custom_data as $row) { ?>
                                        <div class="form-group">
                                            <label for="" class="control-label col-xs-4"><?= $row['field_name']; ?></label>
                                            <div class="col-xs-6">
                                                <div class="form_view_field"><?= $row['field_value']; ?></div>
                                            </div>
                                        </div>
                                <?php } ?>
                            </form>
                        </div>
                   <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>