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

                <form role="form" id="frm_add_tithe" method="post" action="<?= site_url("tithes/save") ?>" class="form-horizontal form-groups-bordered">

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
                            <label class="control-label col-xs-4" for="assembly_id"><?= lang('member.member_assembly_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="assembly_id" id="assembly_id">
                                    <option value=""><?= lang('assembly.select_assembly') ?></option>

                                </select>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <?php if (!$numeric_member_id) { ?>
                        <div class='form-group'>
                            <label for="member_id" class="control-label col-xs-4"><?= lang('tithe.tithe_member_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="member_id" id="member_id">
                                    <option value=""><?= lang('tithe.select_member') ?></option>
                                    <?php foreach ($members as $member) : ?>
                                        <option value="<?php echo $member['id']; ?>"><?php echo $member['first_name'] . ' ' . $member['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="member_id" id="member_id" value="<?= $member_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="amount">
                            <?= lang('tithe.tithe_amount') ?>
                        </label>
                        <div class="col-xs-6">
                            <!-- onkeydown="return false;" -->
                            <input type="text" class="form-control" name="amount" id="amount"
                                placeholder="<?= lang('tithe.enter_tithe_amount') ?>">
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

<script>
    // $("#denomination_id").on("change", function() {
    //     const numeric_denomination_id = $(this).val()

    //     $.ajax({
    //         url: "<?= site_url('entities/lowestEntities') ?>/" + numeric_denomination_id,
    //         type: 'GET',
    //         success: function(response) {
    //             let options = "<option value='0'>Select Entity</option>"

    //             $.each(response, function(index, elem) {
    //                 options += "<option value='" + elem.id + "'>" + elem.name + "</option>";
    //             })

    //             $("#entity_id").html(options)
    //             // console.log(response)
    //         }
    //     })
    // })
</script>