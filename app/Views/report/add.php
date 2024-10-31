<?php
// echo $parent_id;
$numeric_denomination_id = $denomination_id;
$numeric_assembly_id = hash_id($assembly_id, 'decode');

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

        <form role="form" id="frm_add_report" method="post" action="<?= site_url("reports/save") ?>" class="form-horizontal form-groups-bordered">

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

          <input type="hidden" name="reports_type_id" id="reports_type_id" value="<?=$parent_id;?>" />

          <?php if (!$numeric_denomination_id) { ?>
            <div class='form-group'>
              <label for="denomination_id" class="control-label col-xs-4"><?= lang('report.report_denomination_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="denomination_id" id="denomination_id">
                  <option value=""><?= lang('report.select_denomination') ?></option>
                  <?php foreach ($denominations as $denomination) : ?>
                    <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
          <?php } ?>

          <?php if (!$numeric_assembly_id) { ?>
            <div class='form-group'>
              <label for="assembly_id" class="control-label col-xs-4"><?= lang('report.report_assembly_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="assembly_id" id="assembly_id">
                  <option value=""><?= lang('report.select_assembly') ?></option>
                  <?php foreach ($assemblies as $assembly) : ?>
                    <option value="<?php echo $assembly['id']; ?>"><?php echo $assembly['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="assembly_id" id="assembly_id" value="<?= $assembly_id; ?>" />
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