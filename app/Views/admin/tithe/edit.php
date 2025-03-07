<?php 
// echo json_encode($designations);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('tithe.edit_tithe') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_tithe" method="post" action="<?= site_url('tithes/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />
                    <input type="hidden" name="assembly_id" value="<?= hash_id($result['assembly_id']); ?>" />


                    <div class='form-group'>
                        <label for="member_id" class="control-label col-xs-4"><?= lang('tithe.tithe_member_name') ?></label>
                        <div class="col-xs-6">
                            <select class="form-control" name="member_id" id="member_id">

                                <?php if(!empty($members)){
                                    foreach($members as $member){    
                                ?>
                                    <option value="<?= $member['id']; ?>" <?= $result['member_id'] == $member['id'] ? "selected" : ""; ?> ><?= $member['first_name'].' '.$member['last_name']; ?></option>
                                <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="amount">
                            <?= lang('tithe.tithing_date') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="date" class="form-control" name="tithing_date" id="tithing_date" value="<?= $result['tithing_date']; ?>" placeholder="<?= lang('tithe.edit_tithe_amount') ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="amount">
                            <?= lang('tithe.tithe_amount') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="amount" id="amount" value="<?= $result['amount']; ?>" placeholder="<?= lang('tithe.edit_tithe_amount') ?>">
                        </div>
                    </div>

                    <?php if (!empty($customFields)): ?>
                        <?php foreach ($customFields as $field): ?>
                            <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                                <label class="control-label col-xs-4" for="<?= $field['field_name'] ?>"><?= ucfirst($field['field_name']) ?></label>
                                <div class="col-xs-6">
                                    <input type="<?= $field['type'] ?>"
                                        name="custom_fields[<?= $field['id'] ?>]"
                                        id="<?= $field['field_name'] ?>"
                                        value="<?= $customFieldValuesInDB['value'] ?? '' ?>"
                                        class="form-control">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>
</d>