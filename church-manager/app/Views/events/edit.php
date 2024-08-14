<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("ministers"); ?>" class="btn btn-info">
            <?= lang("minister.back_button") ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang("minister.edit_minister") ?>  
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <form method="post" action="<?=site_url("denominations/update/".hash_id($result['name']));?>" role="form" class="form-horizontal form-groups-bordered">
                    
                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang("minister.minister_name") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Edit Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="minister_number">
                            <?= lang("minister.minister_number") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" onkeydown="return false;" class="form-control datepicker"
                                name="minister_number" id="minister_number" value="<?=$result['minister_number'];?>" placeholder="Edit Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="assembly_id">
                            <?= lang("minister.minister_assembly_id") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="assembly_id" id="assembly_id" 
                                value="<?=$result['assembly_id'];?>" placeholder="Edit Assembly Id">
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="head_office">
                            <?= lang("minister.minister_head_office") ?>  
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="head_office" value="<?=$result['head_office'];?>" id="head_office"
                                placeholder="Edit Head Office">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="designation_id">
                            <?= lang('minister.designation_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="designation_id" id="designation_id" 
                                value="<?=$result['designation_id'];?>" placeholder="Edit Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">
                            <?= lang("minister.minister_phone") ?>  
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="phone" id="phone" 
                                value="<?=$result['phone'];?>" placeholder="Enter Phone">
                        </div>
                    </div>

                    <div class="form-group">
                    <div class="col-xs-offset-4 col-xs-6">
                        <button type="submit" class="btn btn-primary">
                            <?= lang("minister.update_minister") ?>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <?= lang("minister.update_and_continue") ?>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <?= lang("minister.refresh_minister_form") ?>
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>