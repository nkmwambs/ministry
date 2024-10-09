<?php
$numeric_denomination_id = hash_id($parent_id, 'decode');
$numeric_meeting_id = hash_id($meeting_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('event.add_event') ?></div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_event" method="post" action="<?= site_url("events/save") ?>" class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

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

          <?php if (!$numeric_denomination_id) { ?>
            <div class='form-group'>
              <label for="denomination_id" class="control-label col-xs-4"><?= lang('event.event_denomination_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="denomination_id" id="denomination_id">
                  <option value=""><?= lang('event.select_denomination') ?></option>
                  <?php foreach ($denominations as $denomination) : ?>
                    <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
          <?php } ?>

          <?php if (!$numeric_meeting_id) { ?>
            <div class='form-group'>
              <label for="denomination_id" class="control-label col-xs-4"><?= lang('event.event_meeting_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="meeting_id" id="meeting_id">
                  <option value=""><?= lang('event.select_meeting') ?></option>
                  <?php foreach ($meetings as $meeting) : ?>
                    <option value="<?php echo $meeting['id']; ?>"><?php echo $meeting['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="meeting_id" id="meeting_id" value="<?= $meeting_id; ?>" />
          <?php } ?>

          <div class="form-group">
            <label class="control-label col-xs-4" for="name">
              <?= lang('event.event_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="code">
              <?= lang('event.event_code') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="code" id="code"
                placeholder="<?= lang('event.enter_code') ?>">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="start_date">
              <?= lang('event.event_start_date') ?>
            </label>
            <div class="col-xs-6">
              <!-- onkeydown="return false;" -->
              <input type="text" onkeydown="return false" class="form-control datepicker" name="start_date"
                id="start_date" placeholder="Enter Start Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="end_date">
              <?= lang('event.event_end_date') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control datepicker" name="end_date" id="end_date"
                placeholder="Enter End Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="location">
              <?= lang('event.event_location') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="description">
              <?= lang('event.event_description') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_fees">
              <?= lang('event.event_registration_fees') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="registration_fees" id="registration_fees" placeholder="Enter Registration Fees">
            </div>
          </div>

          <!-- Dynamically Generated Custom Fields -->
          <?php foreach ($customFields as $field): ?>
            <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
              <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
              <div class="col-xs-6">
                <input type="<?= $field['type'] ?>" name="custom_fields[<?= $field['id'] ?>]" id="<?= $field['field_name'] ?>" class="form-control">
              </div>
            </div>
          <?php endforeach; ?>
          
        </form>

      </div>

    </div>

  </div>
</div>