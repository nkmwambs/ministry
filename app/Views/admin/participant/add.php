<?php
// $numeric_member_id = hash_id($member_id, 'decode');
// $numeric_payment_id = hash_id($payment_id, 'decode');

?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('participant.event_register') ?></div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_participant" method="post" action="<?=site_url("participants/save")?>" class="form-horizontal form-groups-bordered">
          
          <div class="form-group hidden error_container">
            <div class="col-xs-12 message error"></div>
          </div>

          <!-- <div class="form-group hidden message_container">
            <div class="col-xs-12 info"></div>
          </div> -->
          
            <div class='form-group'>
              <label for="member_id" class="control-label col-xs-4"><?= lang('participant.participant_member_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control select_fields" name="member_id[]" id="member_id" multiple>
                  <!-- <option value=""><?= lang('participant.select_member') ?></option> -->
                  <?php foreach ($members as $member) : ?>
                    <option value="<?php echo $member['id']; ?>"><?= $member['first_name']; ?> <?=  $member['last_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
              
          <?php 
            if(isset($id)){
          ?>
            <input type="hidden" name="event_id" value="<?=$parent_id;?>" />
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
              <label class="control-label col-xs-4" for="registration_amount">
                <?= lang('participant.participant_registration_amount') ?>
              </label>
              <div class="col-xs-6">
                <input type="text" class="form-control" readonly name="registration_amount" id="registration_amount" value="<?=$registration_fees;?>"></i>
              </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="due_registration_amount">
              <?= lang('participant.participant_due_registration_amount') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" readonly name="due_registration_amount" id="due_registration_amount" placeholder="Due Registration Amount"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="paying_phone_number">
              <?= lang('participant.paying_phone_number') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="paying_phone_number" id="paying_phone_number" placeholder="Paying Phone Number"></i>
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

    $("#modal_reset").removeClass('disabled');
    $("#modal_save").removeClass('disabled');
    $("#paying_phone_number").prop('readonly', false);
    $("#member_id").prop('readonly', false);
    $("#member_id").prop('disabled', false);

    $("#member_id").on('change', function() {
      const countMembers = $("#member_id").find("option:selected").length;
      const registration_amount = $("#registration_amount").val()
      let due_amount = 0;

      if(countMembers > 0){
        due_amount = parseFloat(registration_amount) * parseFloat(countMembers)
        $("#due_registration_amount").val(due_amount.toFixed(2))
      }
    })

    $(document).on('click',"#modal_save", function(){
        const error_container = $(".error_container")
        const paying_phone_number = $("#paying_phone_number").val();
        const due_registration_amount = $("#due_registration_amount").val();

        if(paying_phone_number.length > 0 && due_registration_amount > 0){
          error_container.removeClass('hidden');
          error_container.find('.message').toggleClass('error info');
          error_container.find('.info').html('Please complete making the payment from your phone');

          // Enable #modal_save and #modal_reset button 
          $("#modal_reset").addClass('disabled');
          $("#modal_save").addClass('disabled');
          $("#paying_phone_number").prop('readonly', true);
          $("#member_id").prop('readonly', true);
          $("#member_id").prop('disabled', true);
        }
    })

    $("#modal_save").html('<?=lang(line: 'participant.participant_pay');?>')
  })
</script>