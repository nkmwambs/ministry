<?php
$participant_sections = array_pop($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("events"); ?>" class="btn btn-info">
            <?= lang('event.back_button') ?>
        </a>
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
                            <li><a href="#list_participants" data-item_id="<?= $id; ?>" data-feature_plural="participants" onclick="childrenAjaxLists(this)" id="list_participants_tab" data-toggle="tab"><?= lang('participant.list_participants'); ?></a></li>
                            <li><a href="#list_visitors" data-item_id="<?= $id; ?>" data-feature_plural="visitors" onclick="childrenAjaxLists(this)" id="list_visitors_tab" data-toggle="tab">List Visitors</a></li>
                        </ul>
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
                                        <?= lang('event.edit_button') ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- <div class="tab-pane ajax_main" id="list_participants">
                        <div class='info'><?= lang('participant.no_participants_message') ?></div>
                    </div> -->

                    <div class="tab-pane" id="list_participants">
                        <div class="row">
                            <div class="col-xs-12 btn-container">
                                <div class='btn btn-primary' onclick="showAjaxModal('participants','add', '<?= $id; ?>')">
                                    <?= lang('participant.add_participant'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- <?php if (!empty($participants)) { ?> -->
                                    <table class="table table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th><?= lang('participant.participant_action') ?></th>
                                                <th><?= lang('participant.participant_member_id') ?></th>
                                                <th><?= lang('participant.participant_payment_id') ?></th>
                                                <th><?= lang('participant.participant_payment_code') ?></th>
                                                <th><?= lang('participant.participant_registration_amount') ?></th>
                                                <th><?= lang('participant.participant_status') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($participants as $participant) { ?>
                                                <tr>
                                                    <td>
                                                        <span class='action-icons' title="View participant">
                                                            <a href="<?= site_url("participants/view/" . hash_id($participant['id'])); ?>"><i class='fa fa-search'></i></a>
                                                        </span>
                                                        <span class='action-icons' title="Edit participant">
                                                            <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($participant['id']); ?>')" class='fa fa-pencil'></i>
                                                        </span>
                                                        <span class='action-icons' title="Delete participant"><i class='fa fa-trash'></i></span>
                                                    </td>
                                                    <td><?= $participant['member_id']; ?></td>
                                                    <td><?= $participant['payment_id']; ?></td>
                                                    <td><?= $participant['payment_code']; ?></td>
                                                    <td><?= $participant['registration_amount']; ?></td>
                                                    <td><?= $participant['status']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <!-- <?php } else { ?>
                                    <div class='info'><?= lang('participant.no_participants_message') ?></div>
                                <?php } ?> -->
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane" id="list_visitors">
                        <div class="row">
                            <div class="col-xs-12 btn-container">
                                <div class='btn btn-primary' onclick="showAjaxModal('participants','add', '<?= $id; ?>')">
                                    <?= lang('visitor.add_visitor'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <!-- <?php if (!empty($visitors)) { ?> -->
                                    <table class="table table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th><?= lang('visitor.visitor_action') ?></th>
                                                <th><?= lang('visitor.visitor_member_id') ?></th>
                                                <th><?= lang('visitor.visitor_payment_id') ?></th>
                                                <th><?= lang('visitor.visitor_payment_code') ?></th>
                                                <th><?= lang('visitor.visitor_registration_amount') ?></th>
                                                <th><?= lang('visitor.visitor_status') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($visitors as $visitor) { ?>
                                                <tr>
                                                    <td>
                                                        <span class='action-icons' title="View visitor">
                                                            <a href="<?= site_url("visitors/view/" . hash_id($visitor['id'])); ?>"><i class='fa fa-search'></i></a>
                                                        </span>
                                                        <span class='action-icons' title="Edit visitor">
                                                            <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($visitor['id']); ?>')" class='fa fa-pencil'></i>
                                                        </span>
                                                        <span class='action-icons' title="Delete visitor"><i class='fa fa-trash'></i></span>
                                                    </td>
                                                    <td><?= $visitor['member_id']; ?></td>
                                                    <td><?= $visitor['payment_id']; ?></td>
                                                    <td><?= $visitor['payment_code']; ?></td>
                                                    <td><?= $visitor['registration_amount']; ?></td>
                                                    <td><?= $visitor['status']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <!-- <?php } else { ?>
                                    <div class='info'><?= lang('visitor.no_visitors_message') ?></div>
                                <?php } ?> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $('.datatable<?=$id;?>').DataTable({
        stateSave: true
      });
    });
</script>