<?php
$numeric_payment_id = hash_id($payment_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('visitor.add_visitor') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_visitor" method="post" action="<?= site_url("visitor/save") ?>" class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-xs-2" for="first_name"><?= lang('visitor.visitor_first_name') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
            </div>

            <label class="control-label col-xs-2" for="last_name"><?= lang('visitor.visitor_last_name') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="phone"><?= lang('visitor.visitor_phone') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
            </div>

            <label class="control-label col-xs-2" for="email"><?= lang('visitor.visitor_email') ?></label>
            <div class="col-xs-3">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="gender">
              <?= lang('visitor.visitor_gender') ?>
            </label>
            <div class="col-xs-3">
              <select class="form-control" name="date_of_birth" id="date_of_birth">
                <option value="male"><?= lang('system.gender_male') ?></option>
                <option value="female"><?= lang('system.gender_female') ?></option>
              </select>
            </div>

            <label class="control-label col-xs-2" for="date_of_birth">
              <?= lang('visitor.visitor_date_of_birth') ?>
            </label>
            <div class="col-xs-3">
              <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Date of birth">
            </div>
          </div>

          <div class='form-group'>
            <label class="control-label col-xs-2" for="payment_code"><?= lang('visitor.visitor_payment_code') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="payment_code" id="payment_code" placeholder="Enter Payment Code">
            </div>

            <?php if (!$numeric_payment_id) { ?>
              <label for="payment_id" class="control-label col-xs-2"><?= lang('visitor.visitor_payment_id') ?></label>
              <div class="col-xs-3">
                <select class="form-control" name="payment_id" id="payment_id">
                  <option value=""><?= lang('visitor.select_payment') ?></option>
                  <?php foreach ($payments as $payment) : ?>
                    <option value="<?php echo $payment['id']; ?>"><?php echo $payment['payment_code']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
          </div>
        <?php } else { ?>
          <input type="hidden" name="payment_id" id="payment_id" value="<?= $payment_id; ?>" />
        <?php } ?>

        <div class="form-group">
          <label class="control-label col-xs-2" for="registration_amount"><?= lang('visitor.visitor_registration_amount') ?></label>
          <div class="col-xs-3">
            <input type="text" class="form-control" name="registration_amount" id="registration_amount" placeholder="Enter Registration Amount">
          </div>

          <label class="control-label col-xs-2" for="status"><?= lang('visitor.visitor_status') ?></label>
          <div class="col-xs-3">
            <select type="text" class="form-control" name="status" id="status">
              <option value=""><?= lang('visitor.visitor_status') ?></option>
              <option value="registered">Registered</option>
              <option value="attended">Attended</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <?php
        if (isset($id)) {
        ?>
          <input type="hidden" name="event_id" value="<?= $id; ?>" />
        <?php
        } else {
        ?>
          <div class="form-group">
            <label class="control-label col-xs-4" for="event_id"><?= lang('event.event_name') ?></label>
            <div class="col-xs-6">
              <select class="form-control" name="event_id" id="event_id">
                <option value=""><?= lang('visitor.select_event') ?></option>

              </select>
            </div>
          </div>
        <?php
        }
        ?>
        </form>
      </div>
    </div>
  </div>
</div>
