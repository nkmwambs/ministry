<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("ministers"); ?>" class="btn btn-info">
            <?= lang('minister.back_button') ?>
        </a>
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
                            <li class="active"><a href="#view_minister" id="view_minister_tab" data-toggle="tab"><?= lang('minister.view_minister'); ?></a></li>
                            <!-- <li><a href="#list_hierarchies" data-item_id="<?= $id; ?>" data-feature_plural="hierarchies" onclick="childrenAjaxLists(this)" id="list_hierarchies_tab" data-toggle="tab"><?= lang('hierarchy.list_hierarchies'); ?></a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_minister">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $department => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($department); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">
                                        <?= lang('minister.edit_button') ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane ajax_main" id="list_hierarchies">
                        <div class='info'><?= lang('hierarchy.no_hierarchies_message') ?></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>