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
        
          <div class="form-group">
            <label class="control-label col-xs-4" for="member_id">
              <?= lang('participant.participant_member_id') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="member_id" id="member_id"
                placeholder="Enter Member Name">
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
          
          <div class="form-group">
            <label class="control-label col-xs-4" for="payment_id">
              <?= lang('participant.participant_payment_id') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="payment_id" id="payment_id" placeholder="Enter Payment Name"></i>
            </div>
          </div>

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
              <input type="text" class="form-control" name="status" id="status" placeholder="Enter Status"></i>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>