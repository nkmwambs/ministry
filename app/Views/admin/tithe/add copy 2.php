<?php
$numeric_member_id = hash_id($member_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('tithe.add_tithe') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_tithe" method="post" action="<?= site_url("tithes/save") ?>"
                    class="form-horizontal form-groups-bordered">

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

                    <?php
                    if (isset($parent_id)) {
                        ?>
                        <input type="hidden" name="assembly_id" value="<?= $parent_id; ?>" />
                        <?php
                    } else {
                        ?>
                        <div class="form-group">
                            <label class="control-label col-xs-4"
                                for="assembly_id"><?= lang('member.member_assembly_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="assembly_id" id="assembly_id">
                                    <option value=""><?= lang('assembly.select_assembly') ?></option>

                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4"
                            for="tithing_date"><?= lang('tithe.tithe_choose_tithing_date') ?></label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control collection_datepicker" name="tithing_date"
                                id="tithing_date" placeholder="<?= lang('tithe.select_tithing_date') ?>">
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
                            <?php if (!$numeric_member_id) { ?>
                                <div class="col-xs-4">
                                    <select class="form-control" name="member_id[]" id="member_id">
                                        <option value=""><?= lang('tithe.select_member') ?></option>
                                        <?php foreach ($members as $member): ?>
                                            <option value="<?php echo $member['id']; ?>">
                                                <?php echo $member['first_name'] . ' ' . $member['last_name']; ?></option>
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
     $(document).on("click", ".remove_tithe_button", function () {
    $(this).parent().parent().remove();
  })

  $(document).on("click", ".add_tithe_button", function () {
    var new_row = $('.section-content').eq(0).clone();

    // new_row.find('input').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="number"]').val('');

    new_row.find('.add_tithe_button').remove();
    new_row.find('.remove_tithe_button').removeClass('hidden');

    new_row.appendTo('.tithe_section');
  })
</script>