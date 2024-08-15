<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i> Add Denomination</div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_denomination" method="post" action="<?=site_url("denominations/save")?>" class="form-horizontal form-groups-bordered">
          
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
            <label class="control-label col-xs-4" for="name">Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="code">Code</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_date">Registration Date</label>
            <div class="col-xs-6">
            <!-- onkeydown="return false;" -->
              <input type="text"  class="form-control datepicker" name="registration_date"
                id="registration_date" placeholder="Enter Registration Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="head_office">Head Office</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="head_office" id="head_office"
                placeholder="Enter Head Office">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="email">Email</label>
            <div class="col-xs-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">Phone</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>

