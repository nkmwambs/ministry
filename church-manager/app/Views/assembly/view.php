<?php
// echo json_encode($result);
$member_sections = array_pop($result);
?>
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
            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>">Edit Again</a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('assembly.view_assembly'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active"><a href="#view_assembly" id="view_assembly_tab" data-toggle="tab"><?= lang('assembly.view_assembly'); ?></a></li>
                            <li><a href="#list_members" data-item_id="<?= $id; ?>" data-link_id="list_members" data-feature_plural="members" onclick="childrenAjaxLists(this)" id="list_members_tab" data-toggle="tab"><?= lang('member.list_members'); ?></a></li>
                            <li><a href="#list_collections" data-item_id="<?= $id; ?>" data-link_id="list_collections" data-feature_plural="collections" onclick="childrenAjaxLists(this)" id="list_collections_tab" data-toggle="tab"><?= lang('collection.list_collections'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_assembly">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $department => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($department); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= ucwords($field_value); ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div>  -->
                        </form>
                    </div>

                    <div class="tab-pane" id="list_members">
                        <div class='info'><?= lang('assembly.no_assemblies_message') ?></div>
                    </div>

                    <div class="tab-pane" id="list_collections">
                        <div class='info'><?= lang('assembly.no_assemblies_message') ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>