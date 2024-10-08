<?php
$numeric_report_type_id = hash_id($reports_type_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i>
          <?= lang('report.add_report') ?>
        </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_report" method="post" action="<?=site_url("reports/save")?>" class="form-horizontal form-groups-bordered">
          
          <!-- <?php if (session()->get('errors')): ?>
              <div class="form-group">
                  <div class="col-xs-12 error">
                    <ul>
                        <?php foreach (session()->get('errors') as $error): ?>
                          <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                  </div>
              </div>
          <?php endif ?> -->

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">
              
            </div>
          </div>

          <?php if (!$numeric_report_type_id) { ?>
            <div class='form-group'>
              <label for="reports_type_id" class="control-label col-xs-4"><?= lang('report.report_type_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="reports_type_id" id="reports_type_id">
                  <option value=""><?= lang('report.select_report_type') ?></option>
                  <?php foreach ($types as $type) : ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="reports_type_id" id="reports_type_id" value="<?= $reports_type_id; ?>" />
          <?php } ?>

          <div class="form-group">
            <label class="control-label col-xs-4" for="report_period">
              <?= lang('report.report_period') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control datepicker" name="report_period" id="report_period" placeholder="Enter Report Period">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="report_date">
              <?= lang("report.report_date") ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control datepicker" name="report_date" id="report_date" placeholder="Enter Report Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="status">
              <?= lang('report.report_status') ?>
            </label>
            <div class="col-xs-6">
              <select type="text" class="form-control" name="status" id="status">
                <option value="draft">Draft</option>
                <option value="submitted">Submitted</option>
                <option value="approved">Approved</option>
              </select>
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

<script>
  $(document).ready(function() {
    const visible = $('.custom_field_container').attr('id');
    console.log(visible);

    if (visible === "no") {
      $('.custom_field_container').addClass('hidden');
    }
  })
</script>