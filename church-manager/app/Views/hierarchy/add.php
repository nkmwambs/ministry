<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('hierarchy.add_hierarchy') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_hierarchy" method="post" action="<?=site_url("hierarchies/save")?>" class="form-horizontal form-groups-bordered">
          
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
        
          <div class="form-group">
            <label class="control-label col-xs-4" for="denomination_name">
              <?= lang('hierarchy.hierarchy_name') ?>
            </label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name">
            </div>
          </div>
              

          <?php 
            if(isset($id)){
          ?>
            <input type="hidden" name="denomination_id" value="<?=$id;?>" />
          <?php 
            }else{
          ?>
            <div class="form-group">
              <label class="control-label col-xs-4" for="denomination_id">
                <?= lang('hierarchy.hierarchy_denomination_id') ?>
              </label>
              <div class="col-xs-6">
                <select class="form-control" name="denomination_id" id="denomination_id">
                  <option value=""><?= lang('hierarchy.select_denomination') ?></option>
                  
                </select>
              </div>
            </div>
          <?php 
            }
          ?>
          

          <div class="form-group">
            <label class="control-label col-xs-4" for="description">
              <?= lang('hierarchy.hierarchy_description') ?>
            </label>
            <div class="col-xs-6">
              <textarea class="form-control" name="description" id="description" placeholder="Enter description"></textarea>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>