<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('participant.add_participant') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_visitor" method="post" action="<?=site_url("visitor/save")?>" class="form-horizontal form-groups-bordered">
          
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
            <label class="control-label col-xs-4" for="visitor_first_name">
              <?= lang('visitor.visitor_first_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="first_name" id="first_name"
                placeholder="Enter First Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="visitor_last_name">
              <?= lang('visitor.visitor_last_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="last_name" id="last_name"
                placeholder="Enter Last Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone_number">
              <?= lang('visitor.visitor_phone_number') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number">
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="email">
              <?= lang('visitor.visitor_email') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email">
          </div>
          
          <div class="form-group">
            <label class="control-label col-xs-4" for="gender">
              <?= lang('visitor.visitor_gender') ?>
            </label>
            <div class="col-xs-6">
              <input class="text" class="form-control datepicker" name="gender" id="gender" placeholder="Enter Gender">
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="date_of_birth">
              <?= lang('visitor.visitor_date_of_birth') ?>
            </label>
            <div class="col-xs-6">
              <input class="text" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Enter Date of Birth">
          </div>

          <?php 
            if(isset($id)){
          ?>
            <input type="hidden" name="event_id" value="<?=$id;?>" />
          <?php 
            }else{
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

          <div class="form-group">
            <label class="control-label col-xs-4" for="payment_id">
              <?= lang('visitor.visitor_payment_id') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="payment_id" id="payment_id" placeholder="Enter Payment Name">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-xs-4" for="payment_code">
              <?= lang('visitor.visitor_payment_code') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="payment_code" id="payment_code" placeholder="Enter Payment Code">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_amount">
              <?= lang('visitor.visitor_registration_amount') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="registration_amount" id="registration_amount" placeholder="Enter Registration Amount">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="status">
              <?= lang('visitor.visitor_status') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="status" id="status" placeholder="Enter Status">
            </div>
          </div>
    
        </form>

      </div>

    </div>

  </div>
</div>