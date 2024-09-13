<?php
$numeric_member_id = hash_id($member_id, 'decode');
$numeric_payment_id = hash_id($payment_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('participant.add_participant') ?></div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_participant" method="post" action="<?=site_url("participants/save")?>" class="form-horizontal form-groups-bordered">
          
          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">
              
            </div>
          </div>

          <?php if (!$numeric_member_id) { ?>
            <div class='form-group'>
              <label for="member_id" class="control-label col-xs-4"><?= lang('participant.participant_payment_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="member_id" id="member_id">
                  <option value=""><?= lang('participant.select_member') ?></option>
                  <?php foreach ($members as $member) : ?>
                    <option value="<?php echo $member['id']; ?>"><?php echo $member['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="member_id" id="member_id" value="<?= $member_id; ?>" />
          <?php } ?>
        
          <!-- <div class="form-group">
            <label class="control-label col-xs-4" for="member_id">
              <?= lang('participant.participant_member_id') ?>
            </label>
            <div class="col-xs-6">
              <select class="form-control" name="member_id" id="member_id">
                <option value=""><?= lang('participant.select_member_name') ?></option>
                <!-- <?php 
                  if(isset($parent_entities)){
                    foreach($parent_entities as $entity){?>
                      <option value = "<?=$entity['id'];?>"><?=$entity['member_id'];?></option>
                <?php 
                    }
                  }
                ?> -->
              </select>
            </div>
          </div> -->
              
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

          <div class="form-group">
            <label class="control-label col-xs-4" for="status">
              <?= lang('participant.participant_status') ?>
            </label>
            <div class="col-xs-6">
              <select class="form-control select_fields" name="status" id="status">
                <option value="">Select Status</option>
                <option value="registered">Registered</option>
                <option value="attended">Attended</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>