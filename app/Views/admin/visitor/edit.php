<?php
// $numeric_payment_id = hash_id($payment_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('visitor.edit_visitor') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_event" method="post" action="<?= site_url('visitors/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

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
                        <label class="control-label col-xs-2" for="first_name">
                            <?= lang('visitor.visitor_first_name') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="first_name" value="<?= $result['first_name']; ?>" id="first_name">
                        </div>

                        <label class="control-label col-xs-2" for="last_name">
                            <?= lang('visitor.visitor_last_name') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $result['last_name']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2" for="phone">
                            <?= lang('visitor.visitor_phone') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="phone" value="<?= $result['phone']; ?>" id="phone">
                        </div>

                        <label class="control-label col-xs-2" for="email">
                            <?= lang('visitor.visitor_email') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="email" class="form-control" name="email" value="<?= $result['email']; ?>" id="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2" for="gender">
                            <?= lang('visitor.visitor_email') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="gender" value="<?= $result['gender']; ?>" id="gender">
                        </div>

                        <label class="control-label col-xs-2" for="date_of_birth">
                            <?= lang('visitor.visitor_date_of_birth') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control datepicker" name="date_of_birth" value="<?= $result['date_of_birth']; ?>" id="date_of_birth">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2" for="payment_code">
                            <?= lang('visitor.visitor_payment_code') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="payment_code" value="<?= $result['payment_code']; ?>" id="payment_code">
                        </div>

                        <label for="payment_id" class="control-label col-xs-2"><?= lang('visitor.visitor_payment_id') ?></label>
                        <div class="col-xs-3">
                            <input class="form-control" name="payment_id" id="payment_id" value="<?= $result['payment_id']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-2" for="registration_amount">
                            <?= lang('visitor.visitor_registration_amount') ?>
                        </label>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" name="registration_amount" value="<?= $result['registration_amount']; ?>" id="registration_amount">
                        </div>

                        <label class="control-label col-xs-2" for="status"><?= lang('visitor.visitor_status') ?></label>
                        <div class="col-xs-3">
                            <select type="text" class="form-control" name="status" id="status">
                                <option value="<?= $result['status'] ?>"><?= $result['status'] ?></option>
                                <option value="registered"><?= lang('system.system_registered') ?></option>
                                <option value="attended"><?= lang('system.system_attended') ?></option>
                                <option value="cancelled"><?= lang('system.system_cancelled') ?></option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>