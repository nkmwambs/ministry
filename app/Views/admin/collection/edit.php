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
                            <input type="text" class="form-control datepicker" name="return_date" 
                                value="<?=$result['return_date'];?>" id="return_date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="revenue_id">
                            <?= lang('collection.collection_revenue_id') ?> 
                        </label>
                        <div class="col-xs-6">
                            <!-- <input type="email" class="form-control" name="revenue_id" value="<?=$result['revenue_id'];?>" id="revenue_id"> -->
                            <select class="form-control" name="revenue_id[]" id="revenue_id">
                                <option value=""><?= lang('collection.select_revenue') ?></option>
                                <?php foreach ($revenues as $revenue): ?>
                                    <option value="<?php echo $revenue['id'];?>" <?=$result['revenue_id'] == $revenue['id'] ? 'selected' : '';?>><?php echo $revenue['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="amount">
                            <?= lang('collection.collection_amount') ?> 
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="amount" value="<?=$result['amount'];?>" id="amount">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>