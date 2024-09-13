<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('participant.edit_participant') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_event" method="post" action="<?= site_url('participants/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />
                    <input type="hidden" name="event_id" value="<?= hash_id($result['event_id']); ?>" />

                    <?php if (!$numeric_member_id) { ?>
                        <div class='form-group'>
                            <label for="member_id" class="control-label col-xs-4"><?= lang('participant.participant_payment_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="member_id" id="member_id">
                                    <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                    <?php foreach ($members as $member) : ?>
                                        <option value="<?php echo $member['id']; ?>"><?php echo $member['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="member_id" id="member_id" value="<?= $member_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_id">
                            <?= lang('participant.participant_member_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="member_id" value="<?= $result['member_id']; ?>" id="member_id"
                                placeholder="Edit Member Name">
                        </div>
                    </div>

                    <?php if (!$numeric_payment_id) { ?>
                        <div class="form-group">
                            <label for="payment_id" class="control-label col-xs-4"><?= lang('participant.participant_payment_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="payment_id" id="payment_id">
                                    <option value="<?= $result['name'] ?>"><?= $result['name'] ?></option>
                                    <?php foreach ($payments as $payment) : ?>
                                        <option value="<?php echo $payment['id']; ?>"><?php echo $payment['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="payment_id" id="payment_id" value="<?= $payment_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="payment_code">
                            <?= lang('participant.participant_payment_code') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="payment_code" id="payment_code" value="<?= $result['payment_code']; ?>" placeholder="Edit Payment Code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="registration_amount">
                            <?= lang('participant.participant_registration_amount') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="registration_amount" id="registration_amount" value="<?= $result['registration_amount']; ?>" placeholder="Edit Registration Amount">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="status">
                            <?= lang('participant.participant_status') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="status" id="status" value="<?= $result['status']; ?>" placeholder="Edit Status">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>