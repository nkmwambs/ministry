<div class="row">
  <div class="col-xs-12 btn-container">
    <a href="<?=site_url("add_event");?>" class="btn btn-info">
        <?= lang('event.back_button') ?>
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
            <?= lang("event.add_event") ?> <!-- add minister -->
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" method="post" action="<?=site_url("events")?>" class="form-horizontal form-groups-bordered">
          <div class="form-group">
            <label class="control-label col-xs-4" for="name">
                <?= lang("event.event_name") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="gatheringtype_id">
                <?= lang("event.event_gatheringtype_id") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="gatheringtype_id" id="gatheringtype_id" 
                placeholder="Enter Gathering Type ID">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="start_date">
                <?= lang("event.event_start_date") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" onkeydown="return false;" class="form-control datepicker" name="start_date" id="start_date" 
                placeholder="Enter Start Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="end_date">
                <?= lang("event.event_end_date") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" onkeydown="return false;" class="form-control datepicker" name="end_date" id="end_date"
                placeholder="Enter End Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="location">
                <?= lang("event.event_location") ?> 
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="description">
                <?= lang("event.event_description") ?> 
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="description" id="description" 
                placeholder="Enter Description">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="domination_id">
                <?= lang("event.event_denomination_id") ?> 
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="denomination_id" id="denomination_id" 
                placeholder="Enter Denomination ID">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_fees">
                <?= lang("event.event_registration_fees") ?> 
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="registration_fees" id="registration_fees" 
                placeholder="Enter Denomination ID">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-offset-4 col-xs-6">
              <button type="submit" class="btn btn-primary">
                <?= lang("event.save_event") ?>
              </button>
              <button type="submit" class="btn btn-primary">
                <?= lang("event.save_and_new_event") ?>
              </button>
              <button type="submit" class="btn btn-primary">
                <?= lang("event.reset_event_form") ?>
              </button>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>