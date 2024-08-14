<div class="row">
  <div class="col-xs-12 btn-container">
    <a href="<?=site_url("add_minister");?>" class="btn btn-info">
        <?= lang('minister.back_button') ?>
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang("minister.add_minister") ?> <!-- add minister -->
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" method="post" action="<?=site_url("ministers")?>" class="form-horizontal form-groups-bordered">
          <div class="form-group">
            <label class="control-label col-xs-4" for="name">
                <?= lang("minister.minister_name") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Minister Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="number">
                <?= lang("minister.minister_number") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="number" id="number" placeholder="Enter Minister Number">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="assembly_id">
                <?= lang("minister.assembly_id") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" name="assembly_id" id="assembly_id" placeholder="Enter Registration Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="designation_id">
                <?= lang("minister.designation_id") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="designation_id" id="designation_id"
                placeholder="Enter Head Office">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">
                <?= lang("minister.phone") ?> 
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-offset-4 col-xs-6">
              <button type="submit" class="btn btn-primary">
                <?= lang("minister.save_minister") ?>
              </button>
              <button type="submit" class="btn btn-primary">
                <?= lang("minister.save_and_new_minister") ?>
              </button>
              <button type="submit" class="btn btn-primary">
                <?= lang("minister.reset_minister_form") ?>
              </button>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>