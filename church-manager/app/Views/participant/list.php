<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('participant.list_participants'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('participants','add', '<?= $id; ?>')">
            <?= lang('participant.add_participant'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($participants)) { ?>
            <table class="table table-striped datatable">
                <thead>
                    <tr>

                        <th><?= lang('participant.participant_action') ?></th>
                        <th><?= lang('participant.participant_member_id') ?></th>
                        <th><?= lang('participant.participant_event_id') ?></th>
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
                                    <i style="cursor:pointer" onclick="showAjaxModal('participants','edit', '<?= hash_id($participant['id']); ?>')" class='fa fa-pencil'></i>
                                </span>
                                <span class='action-icons' title="Delete participant"><i class='fa fa-trash'></i></span>
                            </td>

                            <td><?= $participant['member_id']; ?></td>
                            <td><?= $participant['event_id']; ?></td>
                            <td><?= $participant['payment_id']; ?></td>
                            <td><?= $participant['payment_code']; ?></td>
                            <td><?= $participant['registration_amount']; ?></td>
                            <td><?= $participant['status']; ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
                <div class="tab-pane ajax_main" id="list_participants">
                    <div class='info'><?= lang('participant.no_participants_message') ?></div>
                </div>
            <?php } ?>
    </div>
</div>
