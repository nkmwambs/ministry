<?php
$numeric_revenue_id = hash_id($revenue_id, 'decode');
unset($parent_id);
?>

<div class="form-group">
    <label class="control-label col-xs-4" for="assembly_id"><?= lang('collection.collection_assembly_id') ?></label>
    <div class="col-xs-6">
        <select class="form-control" name="assembly_id" id="assembly_id">
            <option value=""><?= lang('collection.assembly_name') ?></option>
            <?php
            foreach ($assemblies as $assembly) {
                ?>
                <option value="<?= $assembly['id']; ?>"><?= $assembly['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4" for="sunday_date"><?= lang('collection.choose_sunday_button') ?></label>
    <div class="col-xs-6">
        <input type="text" class="form-control collection_datepicker reporting_datepicker" name="sunday_date"
            id="sunday_date" placeholder="<?= lang('collection.select_collection_date') ?>">
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