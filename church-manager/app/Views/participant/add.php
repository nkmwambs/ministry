<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('participant.add_participant') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id = "frm_add_participant" method="post" action="<?=site_url("participants/save")?>" class="form-horizontal form-groups-bordered">
          
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
            <label class="control-label col-xs-4" for="participant_name">Name</label>
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
              <label class="control-label col-xs-4" for="denomination_id">Denomination Name</label>
              <div class="col-xs-6">
                <select class="form-control" name="denomination_id" id="denomination_id">
                  <option value="">Select Denomination</option>
                  
                </select>
              </div>
            </div>
          <?php 
            }
          ?>
          

          <div class="form-group">
            <label class="control-label col-xs-4" for="description">Description</label>
            <div class="col-xs-6">
              <textarea class="form-control" name="description" id="description" placeholder="Enter description"></textarea>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>