<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('assembly.edit_assembly') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_assembly" method="post" action="<?=site_url('assemblies/update/');?>" role="form" class="form-horizontal form-groups-bordered">

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
                        <label class="control-label col-xs-4" for="assembly_name">
                            <?= lang('assembly.assembly_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Edit Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="planted_at">
                            <?= lang('assembly.assembly_planted_at') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" onkeydown="return false;" class="form-control datepicker"
                                name="planted_at" id="planted_at" value="<?=$result['planted_at'];?>"
                                placeholder="Enter planted At">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="location">
                            <?= lang('assembly.assembly_location') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="location" id="location"
                                value="<?=$result['location'];?>" placeholder="Enter Location">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="control-label col-xs-4" for="entity_id">
                            <?= lang('assembly.assembly_entity_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="entity_id" value="<?=$result['entity_id'];?>"
                                id="entity_id" placeholder="Enter entity_id ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="assembly_leader">
                            <?= lang('assembly.assembly_leader') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="assembly_leader" value="<?=$result['assembly_leader'];?>" id="assembly_leader"
                                placeholder="Edit Assembly Leader">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_active">
                            <?= lang('assembly.assembly_is_active') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="is_active" id="is_active"
                                value="<?=$result['is_active'];?>" placeholder="Is Active?">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>