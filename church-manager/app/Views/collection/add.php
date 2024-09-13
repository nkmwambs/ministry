<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('collection.add_collection') ?>
          </div>
        </div>
      </div>

      <div class="panel-body">
        <form role="form" id="frm_add_collection" method="post" action="<?= site_url("collections/save") ?>" class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="return_date"><?= lang('collection.collection_return_date') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control datepicker" name="return_date" id="return_date" placeholder="Enter Return Date">
            </div>

            <label class="control-label col-xs-2" for="period_start_date"><?= lang('collection.collection_period_start_date') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control datepicker" name="period_start_date" id="period_start_date" placeholder="Enter Period Start Date">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="period_end_date"><?= lang('collection.collection_period_end_date') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control datepicker" name="period_end_date" id="period_end_date" placeholder="Enter Period End Date">
            </div>

            <label class="control-label col-xs-2" for="revenue_id"><?= lang('collection.collection_revenue_id') ?></label>
            <div class="col-xs-3">
              <input type="email" class="form-control" name="revenue_id" id="revenue_id" placeholder="Enter Collection Type Name">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="amount"><?= lang('collection.collection_amount') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
            </div>

            <label class="control-label col-xs-2" for="collection_reference"><?= lang('collection.collection_collection_reference') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="collection_reference" id="collection_reference" placeholder="Enter Collection Reference">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="description"><?= lang('collection.collection_description') ?></label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
            </div>
          
            <label class="control-label col-xs-2" for="collection_method"><?= lang('collection.collection_collection_method') ?></label>
            <div class="col-xs-3">
              <select type="text" class="form-control" name="collection_method" id="collection_method">
                <option value="" selected>Select Collection Method</option>
                <option value="bank">Bank</option>
                <option value="mobile">Mobile</option>
                <option value="in-person">In Person</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="status"><?= lang('collection.collection_status') ?></label>
            <div class="col-xs-6">
              <select type="text" class="form-control" name="status" id="status">
                <option value="" selected>Select Status</option>
                <option value="approved">Approved</option>
                <option value="submitted">Submitted</option>
              </select>
            </div>
          </div>

          <?php
          if (isset($id)) {
          ?>
            <input type="hidden" name="assembly_id" value="<?= $id; ?>" />
          <?php
          } else {
          ?>
            <!-- <div class="tab"> -->
            <div class="form-group">
              <label class="control-label col-xs-2" for="assembly_id"><?= lang('collection.collection_assembly_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="assembly_id" id="assembly_id">
                  <option value=""><?= lang('collection.select_collection') ?></option>

                </select>
              </div>
            <?php
          }
            ?>

        </form>
      </div>
    </div>
  </div>
</div>
