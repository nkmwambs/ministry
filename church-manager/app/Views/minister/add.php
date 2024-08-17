<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i>
          <?= lang('minister.add_minister') ?>
        </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_minister" method="post" action="<?=site_url("ministers/save")?>" class="form-horizontal form-groups-bordered">
          
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
            <label class="control-label col-xs-4" for="name">
              <?= lang("minister.minister_name") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="number">
              <?= lang('minister.minister_number') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="number" id="number" placeholder="Enter Code">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="assembly_id">
              <?= lang('minister.minister_assembly_id') ?>
            </label>
            <div class="col-xs-6">
            <!-- onkeydown="return false;" -->
              <input type="text" class="form-control" name="assembly_id" id="assembly_id" placeholder="Enter Assembly Id">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="designation_id">
              <?= lang('minister.minister_designation_id') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="designation_id" id="designation_id" placeholder="Enter Designation Id">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">
              <?= lang('minister.minister_phone') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="is_active">
              <?= lang('minister.minister_is_active') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="is_active" id="is_active" placeholder="Enter Active Status">
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>

