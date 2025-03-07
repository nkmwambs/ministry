<div class="form-group">
    <label class="control-label col-xs-4" for="assembly_id"><?= lang('member.member_assembly_id') ?></label>
    <div class="col-xs-6">
        <select class="form-control" name="assembly_id" id="assembly_id">
            <option value=""><?= lang('assembly.select_assembly') ?></option>
            <?php
            foreach ($assemblies as $assembly) {
                ?>
                <option value="<?= $assembly['id']; ?>"><?= $assembly['name']; ?></option>
                <?php
            }
            ?>
        </select>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-xs-4" for="tithing_date"><?= lang('tithe.tithe_choose_tithing_date') ?></label>
    <div class="col-xs-6">
        <input type="text" class="form-control collection_datepicker" name="tithing_date" id="tithing_date"
            placeholder="<?= lang('tithe.select_tithing_date') ?>">
    </div>
</div>

<section class="tithe_section">
    <div class="form-group section-header">
        <div class="collection_title col-xs-4"><?= lang('tithe.add_tithe_button') ?></div>
        <div class="collection_title col-xs-4"><?= lang('tithe.tithe_member_name') ?></div>
        <div class="collection_title col-xs-4"><?= lang('tithe.tithe_amount') ?></div>
    </div>

    <div class="form-group section-content">
        <div class="col-xs-4">
            <div class="btn btn-success add_tithe_button">
                <i class="fa fa-plus-circle"></i>
            </div>

            <div class="btn btn-danger hidden remove_tithe_button">
                <i class="fa fa-minus-circle"></i>
            </div>
        </div>

        <div class="col-xs-4">
            <select class="form-control" name="member_id[]" id="member_id">
                <option value=""><?= lang('tithe.select_member') ?></option>
                <?php foreach ($members as $member): ?>
                    <option value="<?php echo $member['id']; ?>">
                        <?php echo $member['first_name'] . ' ' . $member['last_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="number" class="form-control" name="amount[]" id="amount"
                placeholder="<?= lang('collection.enter_amount') ?>">
        </div>
    </div>
</section>