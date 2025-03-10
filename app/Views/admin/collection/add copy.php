<style>
  .collection_section {
    padding: 15px;
    margin-top: 10px;
    border: groove #fafafa;
  }
</style>

<?php
$numeric_revenue_id = hash_id($revenue_id, 'decode');
unset($parent_id);
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
        <form role="form" id="frm_add_collection" method="post" action="<?= site_url("collections/save") ?>"
          class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <?php
          if (isset($parent_id)) {
            ?>
            <input type="hidden" name="assembly_id" value="<?= $parent_id; ?>" />
            <?php
          } else {
            ?>
            <div class="form-group">
              <label class="control-label col-xs-4"
                for="assembly_id"><?= lang('collection.collection_assembly_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="assembly_id" id="assembly_id">
                  <option value=""><?= lang('collection.assembly_name') ?></option>
                  <?php 
                    foreach($assemblies as $assembly){
                  ?>
                      <option value = "<?=$assembly['id'];?>"><?=$assembly['name'];?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
            </div>
            <?php
          }
          ?>

          <div class="form-group">
            <label class="control-label col-xs-4"
              for="sunday_date"><?= lang('collection.choose_sunday_button') ?></label>
            <div class="col-xs-6">
              <input type="text" class="form-control collection_datepicker reporting_datepicker" name="sunday_date" id="sunday_date"
                placeholder="<?=lang('collection.select_collection_date')?>">
            </div>
          </div>

          <section class="collection_section">
            <div class="form-group section-header">
              <div class="collection_title col-xs-4"><?= lang('collection.add_collection_button') ?></div>
              <div class="collection_title col-xs-4"><?= lang('collection.collection_name') ?></div>
              <div class="collection_title col-xs-4"><?= lang('collection.collection_amount') ?></div>
            </div>

            <div class="form-group section-content">
                <div class="col-xs-4">
                  <div class="btn btn-success add_collection_button">
                    <i class="fa fa-plus-circle"></i>
                  </div>

                  <div class="btn btn-danger hidden remove_collection_button">
                    <i class="fa fa-minus-circle"></i>
                  </div>
                </div>
                <?php if (!$numeric_revenue_id) { ?>
                  <div class="col-xs-4">
                    <select class="form-control" name="revenue_id[]" id="revenue_id">
                      <option value=""><?= lang('collection.select_revenue') ?></option>
                      <?php foreach ($revenues as $revenue): ?>
                        <option value="<?php echo $revenue['id']; ?>"><?php echo $revenue['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                <?php } ?>
                <div class="col-xs-4">
                  <input type="number" class="form-control" name="amount[]" id="amount"
                    placeholder="<?= lang('collection.enter_amount') ?>">
                </div>
            </div>
          </section>

        </form>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).on("click", ".remove_collection_button", function () {
    $(this).parent().parent().remove();
  })

  $(document).on("click", ".add_collection_button", function () {
    var new_row = $('.section-content').eq(0).clone();

    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="number"]').val('');

    new_row.find('.add_collection_button').remove();
    new_row.find('.remove_collection_button').removeClass('hidden');

    new_row.appendTo('.collection_section');
  })

  $(document).ready(function () {
        $('.reporting_datepicker').datepicker({
            format: 'yyyy-MM-dd',
            startDate: "<?=date('Y-m-01', strtotime($currentReportingMonth));?>",
            endDate: "<?=date('Y-m-t', strtotime($currentReportingMonth));?>"
        });
    });
</script>