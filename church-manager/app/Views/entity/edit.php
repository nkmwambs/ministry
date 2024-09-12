<?php 
// echo json_encode($result);
// echo json_encode($parent_id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('entity.edit_entity') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_entity" method="post" action="<?=site_url('entities/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
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

                    <input type="hidden" name="parent_id" value="<?=$parent_id;?>" />
                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />
                    <input type="hidden" name="hierarchy_id" value="<?=hash_id($result['hierarchy_id']);?>" />


                    
                    <div class="form-group">
                        <label class="control-label col-xs-4" for="parent_id">Parent Entity</label>
                        <div class="col-xs-6">
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">Select Hierarchy Level</option>
                            <?php 
                            if(isset($parent_entities)){
                                foreach($parent_entities as $entity){?>
                                <option value = "<?=$entity['id'];?>" <?=$entity['id'] == $result['parent_id'] ? "selected" : "";?> ><?=$entity['name'];?></option>
                            <?php 
                                }
                            }
                        ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group content">
                        <label class="control-label col-xs-4" for="name">Name</label>
                        <div class="col-xs-6">
                        <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                            placeholder="Enter Name" required>
                        </div>
                    </div>
                        
                        <div class="form-group content">
                        <label class="control-label col-xs-4" for="entity_number">Entity Number</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" readonly value="<?=$result['entity_number'];?>" name="entity_number" id="entity_number" required/>
                        </div>
                        </div>

                    <div class="form-group content">
                        <label class="control-label col-xs-4" for="entity_leader">Entity Leader</label>
                        <div class="col-xs-6">
                        <select class="form-control" name="entity_leader" id="entity_leader">
                            <option value="">Select Hierarchy Leader</option>
                        </select>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>