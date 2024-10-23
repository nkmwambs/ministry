<style>
  .collection_section {
    padding: 15px;
    margin-top: 10px;
    border: groove #fafafa;
  }
</style>

<?php
$numeric_revenue_id = hash_id($revenue_id, 'decode');
?>

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

            <div class="form-group">
              <label class="control-label col-xs-4" for="return_date"><?= lang('collection.choose_sunday_button') ?></label>
              <div class="col-xs-6">
                <input type="text" class="form-control datepicker" name="return_date" id="return_date" placeholder="Enter a Sunday">
              </div>
            </div>

            <section class="collection_section">
              <div class="form-group section-header">
                <div class="collection_title col-xs-2"><?= lang('collection.add_collection_button') ?></div>
                <div class="collection_title col-xs-5"><?= lang('collection.collection_name') ?></div>
                <div class="collection_title col-xs-5"><?= lang('collection.collection_amount') ?></div>
              </div>

              <div class="form-group section-content">
                <div class="col-xs-2">
                  <div class="btn btn-success add_collection_button">
                    <i class="fa fa-plus-circle"></i>
                  </div>
                </div>
                <?php if (!$numeric_revenue_id) { ?>
                  <div class="col-xs-5">
                    <select class="form-control" name="revenue_id" id="revenue_id">
                      <option value=""><?= lang('collection.select_revenue') ?></option>
                      <?php foreach ($revenues as $revenue) : ?>
                        <option value="<?php echo $revenue['id']; ?>"><?php echo $revenue['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                <?php } ?>
                <div class="col-xs-5">
                  <input type="number" class="form-control" name="amount[]" id="amount" placeholder="<?= lang('collection.enter_amount') ?>">
                </div>
              </div>
            </section>

            <!-- Dynamically Generated Custom Fields -->

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.add_collection_button').click(function() {
    var new_row = $('.section-content').clone();

    // new_row.find('input').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="number"]').val('');

    new_row.find('.add_collection_button').remove();

    new_row.appendTo('.collection_section');
  })
</script>