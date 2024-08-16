<?php 
// echo json_encode($lookup_items);
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i> Add Entity</div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_entity" method="post" action="<?=site_url("entities/save")?>" class="form-horizontal form-groups-bordered">
          
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

          <input type="hidden" name="hierarchy_id" value="<?=$id;?>" />
        
          <div class="form-group">
            <label class="control-label col-xs-4" for="parent_id">Parent Entity</label>
            <div class="col-xs-6">
              <select class="form-control" name="parent_id" id="parent_id">
                <option value="">Select Hierarchy Level</option>
                <?php foreach($lookup_items['parent_id'] as $entity){?>
                    <option value = "<?=$entity['id'];?>"><?=$entity['name'];?></option>
                <?php }?>
              </select>
            </div>
          </div>

          <div class="form-group hidden">
            <label class="control-label col-xs-4" for="name">Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name" required>
            </div>
          </div>
              
            <div class="form-group hidden">
              <label class="control-label col-xs-4" for="entity_number">Entity Number</label>
              <div class="col-xs-6">
                <input type="text" class="form-control" name="entity_number" id="entity_number" required/>
              </div>
            </div>

          <div class="form-group hidden">
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


<script>
$("#parent_id").on("change", function(){
    const parent_id = $(this).val();
    const form_groups = $('.form-group');
   
    if(parent_id > 0){
      form_groups.filter('.hidden').removeClass('hidden');
    }
})
</script>