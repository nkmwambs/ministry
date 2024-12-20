<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('assembly.add_assembly') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_assembly" method="post" action="<?= site_url("assemblies/save") ?>" class="form-horizontal form-groups-bordered">

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

                    <?php if($parent_id){?>
                        <input type="hidden" name="parent_id" value="<?= $parent_id; ?>" />
                    <?php } else {?>
                        <div class="form-group">
                            <label class="control-label col-xs-4" for="denomination_name">
                                <?= lang('assembly.denomination_name') ?>
                            </label>
                            <div class="col-xs-6">
                                <select class="form-control" id="denomination_id" name="parent_id">
                                    <option value="">Select Denomination</option>
                                    <?php foreach ($denominations as $denomination) :?>
                                        <option value="<?php echo $denomination['id'];?>"><?php echo $denomination['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    <?php }?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('assembly.assembly_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" placeholder="<?= lang('system.system_enter_name') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="planted_at">
                            <?= lang('assembly.assembly_planted_at') ?>
                        </label>
                        <div class="col-xs-6">
                            <!-- onkeydown="return false;" -->
                            <input type="text" class="form-control datepicker" name="planted_at" id="planted_at"
                                placeholder="<?= lang('assembly.enter_planted_date') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="location">
                            <?= lang('assembly.assembly_location') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="location" id="location"
                                placeholder="<?= lang('assembly.enter_location') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="entity_id">
                            <?= lang('assembly.assembly_entity_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" name="entity_id" id="entity_id">
                                <option value=""><?= lang('assembly.select_entity') ?></option>
                                <?php
                                if (!empty($lowest_entities)) {
                                    foreach ($lowest_entities as $entity) :
                                ?>
                                        <option value="<?php echo $entity['id']; ?>"><?php echo $entity['name']; ?></option>
                                <?php
                                    endforeach;
                                }

                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="assembly_leader">
                            <?= lang('assembly.assembly_leader') ?>
                        </label>
                        <div class="col-xs-6">
                            <select class="form-control" name="assembly_leader" id="assembly_leader">
                                <option value=""><?= lang('assembly.select_leader') ?></option>
                            </select>
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
    $("#denomination_id").on("change", function() {
        const numeric_denomination_id = $(this).val()

        $.ajax({
            url: "<?= site_url('entities/lowestEntities') ?>/" + numeric_denomination_id,
            type: 'GET',
            success: function(response) {
                let options = "<option value='0'>Select Entity</option>"

                $.each(response, function(index, elem) {
                    options += "<option value='" + elem.id + "'>" + elem.name + "</option>";
                })

                $("#entity_id").html(options)
                // console.log(response)
            }
        })
    })
</script>