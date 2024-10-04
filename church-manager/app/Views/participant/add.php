<?php
$numeric_member_id = hash_id($member_id, 'decode');
$numeric_payment_id = hash_id($payment_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('event.event_register') ?></div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_participant" method="post" action="<?=site_url("participants/save")?>" class="form-horizontal form-groups-bordered">
          
          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">
              
            </div>
          </div>

          <div class="form-group">
              <label class="control-label col-xs-4" for="participant_is_member"><?= lang('participant.participant_is_member') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="participant_is_member" id="participant_is_member">
                  <option value=""><?= lang('participant.participant_is_member') ?></option>
                  <option value="1"><?= lang(line: 'system.system_yes') ?></option>
                  <option value="0"><?= lang(line: 'system.system_no') ?></option>
                </select>
              </div>
            </div>

          
            <div class='form-group'>
              <label for="member_id" class="control-label col-xs-4"><?= lang('participant.participant_member_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="member_id" id="member_id">
                  <option value=""><?= lang('participant.select_member') ?></option>
                  <?php foreach ($members as $member) : ?>
                    <option value="<?php echo $member['id']; ?>"><?= $member['first_name']; ?> <?=  $member['last_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
              
          <?php 
            if(isset($id)){
          ?>
            <input type="hidden" name="event_id" value="<?=$id;?>" />
          <?php 
            }else{
          ?>
            <div class="form-group">
              <label class="control-label col-xs-4" for="event_id"><?= lang('participant.participant_event_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="event_id" id="event_id">
                  <option value=""><?= lang('participant.select_participant') ?></option>
                  
                </select>
              </div>
            </div>
          <?php 
            }
          ?>

          <?php if (!$numeric_payment_id) { ?>
            <div class="form-group">
              <label for="payment_id" class="control-label col-xs-4"><?= lang('participant.participant_payment_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="payment_id" id="payment_id">
                  <option value=""><?= lang('participant.select_payment') ?></option>
                  <?php foreach ($payments as $payment) : ?>
                    <option value="<?php echo $payment['id']; ?>"><?php echo $payment['phone']; ?></option>
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
              <input type="text" class="form-control" name="payment_code" id="payment_code" placeholder="Enter Payment Code"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_amount">
              <?= lang('participant.participant_registration_amount') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="registration_amount" id="registration_amount" placeholder="Enter Registration Amount"></i>
            </div>
          </div>

          <!-- <div class="form-group">
            <label class="control-label col-xs-4" for="status">
              <?= lang('participant.participant_status') ?>
            </label>
            <div class="col-xs-6">
              <select class="form-control" name="status" id="status">
                <option value="registered">Registered</option>
                <option value="attended">Attended</option>
                <option value="cancelled" selected>Cancelled</option>
              </select>
            </div>
          </div> -->

        </form>

      </div>

    </div>

  </div>
</div>

<script>
  $(document).ready(function () {
    // $('#member_id').closest('.form-group').hide();
    // $("#participant_is_member").change(function () {
    //   if ($(this).val() == 1) {
    //     $("#member_id").prop('disabled', false);
    //   } else {
    //     $("#member_id").prop('disabled', true);
    //   }
    // });
  })
</script>