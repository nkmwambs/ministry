<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('member.add_member') ?></div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_member" method="post" action="<?=site_url("members/save")?>" class="form-horizontal form-groups-bordered">
          
          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">
              
            </div>
          </div>
        
          <div class="form-group">
            <label class="control-label col-xs-4" for="first_name">
              <?= lang('member.member_first_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="first_name" id="first_name"
                placeholder="Enter First Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="last_name">
              <?= lang('member.member_last_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="last_name" id="last_name"
                placeholder="Enter Last Name">
            </div>
          </div>
              
          <?php 
            if(isset($id)){
          ?>
            <input type="hidden" name="assembly_id" value="<?=$id;?>" />
          <?php 
            }else{
          ?>
            <div class="form-group">
              <label class="control-label col-xs-4" for="assembly_id"><?= lang('member.mamber_assembly_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="assembly_id" id="assembly_id">
                  <option value=""><?= lang('assembly.select_assembly') ?></option>
                  
                </select>
              </div>
            </div>
          <?php 
            }
          ?>
          
          <div class="form-group">
            <label class="control-label col-xs-4" for="member_number">
              <?= lang('member.member_member_number') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="member_number" id="member_number" placeholder="Enter Member Number"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="designation_id">
              <?= lang('member.member_designation_id') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="designation_id" id="designation_id" placeholder="Enter Designation Name"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="date_of_birth">
              <?= lang('member.member_date_of_birth') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Enter Date of Birth"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="email">
              <?= lang('member.member_email') ?>
            </label>
            <div class="col-xs-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email"></i>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">
              <?= lang('member.member_phone') ?>
            </label>
            <div class="col-xs-6">
              <input type="email" class="form-control" name="phone" id="phone" placeholder="Enter Phone"></i>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>