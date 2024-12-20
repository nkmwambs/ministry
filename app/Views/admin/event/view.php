<?php
// $visitor_sections = $result->other_details;//array_pop($result);
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
            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>">
                <?= lang('event.edit_again_button') ?>
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
                        <i class='fa fa-eye'></i><?= lang('event.view_event'); ?>
                    </div>
                    <div class="panel-options">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active"><a href="#view_event" id="view_event_tab" data-toggle="tab"><?= lang('event.view_event'); ?></a></li>
                            <li><a href="#list_participants" data-item_id="<?= $id; ?>" data-link_id="list_participants" data-feature_plural="participants" onclick="childrenAjaxLists(this)" id="list_participants_tab" data-toggle="tab"><?= lang('participant.list_participants'); ?></a></li>
                            <li><a href="#list_visitors" data-item_id="<?= $id; ?>" data-link_id="list_visitors" data-feature_plural="visitors" onclick="childrenAjaxLists(this)" id="list_visitors_tab" data-toggle="tab"><?= lang('visitor.list_visitors'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_event">

                        <div class="row">
                            <div class="col-xs-12">
                                <form class="form-horizontal form-groups-bordered" role="form">
                                    <?php
                                    // echo json_encode($result);
                                    // echo count($result);
                                    foreach ($result->toArray() as $key => $value) { ?>
                                        <div class="form-group">
                                            <label for="" class="control-label col-xs-4"><?= humanize($key); ?></label>
                                            <div class="col-xs-6">
                                                <div class="form_view_field"><?php echo $value; ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- <div class="form-group">
                                        <div class="col-xs-offset-4 col-xs-6">
                                            <a href="<?= site_url(plural($feature) . '/edit/' . $id) ?>" class="btn btn-primary">
                                                <?= lang('event.edit_button') ?>
                                            </a>
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane ajax_main" id="list_participants">
                        <div class='info'><?= lang('participant.no_participants_message') ?></div>
                    </div>

                    <div class="tab-pane ajax_main" id="list_visitors">
                        <div class='info'><?= lang('visitor.no_visitors_message') ?></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.datatable<?= $id; ?>').DataTable({
            stateSave: true
        });
    });
</script>