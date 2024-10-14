<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('denomination.add_denomination') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_denomination" method="post" action="<?= site_url("denominations/save") ?>" class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-xs-4" for="name">
              <?= lang('denomination.denomination_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="code">
              <?= lang('denomination.denomination_code') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="code" id="code" placeholder="Enter Code">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="registration_date">
              <?= lang('denomination.denomination_registration_date') ?>
            </label>
            <div class="col-xs-6">
              <!-- onkeydown="return false;" -->
              <input type="text" class="form-control datepicker" name="registration_date"
                id="registration_date" placeholder="Enter Registration Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="head_office">
              <?= lang('denomination.denomination_head_office') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="head_office" id="head_office"
                placeholder="Enter Head Office">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="email">
              <?= lang('denomination.denomination_email') ?>
            </label>
            <div class="col-xs-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">
              <?= lang('denomination.denomination_phone') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
            </div>
          </div>

          <!-- Dynamically Generated Custom Fields -->
          <?php if ($customFields): ?>
            <?php foreach ($customFields as $field): ?>
              <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                <label class="control-label col-xs-4" for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
                <div class="col-xs-6">
                  <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>" class="form-control">
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </form>

      </div>

    </div>

  </div>
</div>