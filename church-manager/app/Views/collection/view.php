<?php 
$collection_sections = array_pop($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("assemblies"); ?>" class="btn btn-info">
            <?= lang('collection.back_button') ?>
        </a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ) { ?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>">
                <?= lang('collection.edit_again_button') ?>
            </a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('collection.view_collection'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_event">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $field_name => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($field_name); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <div class="col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">
                                        <?= lang('collection.edit_button') ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>