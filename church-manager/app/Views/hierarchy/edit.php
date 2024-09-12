<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('hierarchy.edit_hierarchy') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_denomination" method="post" action="<?=site_url('hierarchies/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
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

                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />
                    <input type="hidden" name="denomination_id" value="<?=hash_id($result['denomination_id']);?>" />

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="denomination_name">
                            <?= lang('hierarchy.hierarchy_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('hierarchy.hierarchy_description') ?>
                        </label>
                        <div class="col-xs-6">
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description"><?=$result['description'];?></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>