<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('collection.edit_collection') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_event" method="post" action="<?=site_url('collections/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />
                    <input type="hidden" name="assembly_id" value="<?=hash_id($result['assembly_id']);?>" />

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="return_date">
                            <?= lang('collection.collection_return_date') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="return_date" value="<?=$result['return_date'];?>" id="return_date"
                                placeholder="Edit Return Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="period_start_date">
                            <?= lang('collection.collection_period_start_date') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="period_start_date" id="period_start_date" 
                                placeholder="Edit Period Start Date" value="<?=$result['period_start_date'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="period_end_date">
                            <?= lang('collection.collection_period_end_date') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="period_end_date" value="<?=$result['period_end_date'];?>" id="period_end_date" 
                                placeholder="Edit Period End Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="revenue_id">
                            <?= lang('collection.collection_revenue_id') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="revenue_id" value="<?=$result['revenue_id'];?>" id="revenue_id" 
                                placeholder="Edit Revenue Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="amount">
                            <?= lang('collection.collection_amount') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="amount" value="<?=$result['amount'];?>" id="amount" 
                                placeholder="Edit Amount">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="status">
                            <?= lang('collection.collection_status') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="status" value="<?=$result['status'];?>" id="status" 
                                placeholder="Edit Status">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="collection_reference">
                            <?= lang('collection.collection_collection_reference') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="collection_reference" value="<?=$result['collection_reference'];?>" id="collection_reference" 
                                placeholder="Edit Collection Reference">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('collection.collection_description') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="description" value="<?=$result['description'];?>" id="description" 
                                placeholder="Edit Description">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="collection_method">
                            <?= lang('collection.collection_collection_method') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="collection_method" value="<?=$result['collection_method'];?>" id="collection_method" 
                                placeholder="Edit Collection Method">
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
</div>