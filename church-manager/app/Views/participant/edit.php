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

                    <?php if (session()->get('errors')): ?>
                        <div class="form-group">
                            <div class="col-xs-12 error">
                                <ul>
                                    <?php foreach (session()->get('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_id">
                            <?= lang('participant.participant_member_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="member_id" value="<?= $result['member_id']; ?>" id="member_id"
                                placeholder="Edit Member Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="payment_id">
                            <?= lang('participant.participant_payment_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="payment_id" id="payment_id" value="<?= $result['payment_id']; ?>" placeholder="Edit Payment Name">
                        </div>
                    </div>

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