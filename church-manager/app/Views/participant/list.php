<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('participants','add', '<?= $id; ?>')">
            <?= lang('participant.add_participant'); ?>
        </div>
    </div>
</div>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
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
                <?php foreach ($result as $participant) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $participant['member_id']; ?> participant"><a href="<?= site_url("participants/view/" . hash_id($participant['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i></span>
                            <span class='action-icons' title="Edit <?= $participant['member_id']; ?> participant">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($participant['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= $participant['member_id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $participant['member_id']; ?></td>
                        <td><?= $participant['payment_id']; ?></td>
                        <td><?= $participant['payment_code']; ?></td>
                        <td><?= $participant['registration_amount']; ?></td>
                        <td><?= $participant['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>