<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i>
                    <?= lang('minister.edit_minister') ?>
                </div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_minister" method="post" action="<?=site_url('ministers/update/');?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">
                        
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />

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

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('minister.minister_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Edit Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="number">
                            <?= lang('minister.minister_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="number" id="number" value="<?=$result['number'];?>" 
                                placeholder="Edit Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="assembly_id">
                            <?= lang('minister.assembly_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" name="assembly_id" id="assembly_id" value="<?=$result['assembly_id'];?>" 
                                placeholder="Edit Assembly Id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="designation_id">
                            <?= lang('minister.designation_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="designation_id" value="<?=$result['designation_id'];?>" id="designation_id"
                                placeholder="Edit Designation Id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">
                            <?= lang('minister.minister_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="phone" id="phone" value="<?=$result['phone'];?>" 
                                placeholder="Edit Phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_active">
                            <?= lang('minister.minister_is_active') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="is_active" id="is_active" value="<?=$result['is_active'];?>" 
                                placeholder="Edit Active Status">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>