<div class="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang("$feature.list_".plural($feature)); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <a href="<?= site_url(plural($feature)."/add"); ?>" class='btn btn-primary'>
      <!-- <a href="<?= site_url("modal/load/$feature/add"); ?>" class='btn btn-primary'> -->
        <?= lang("$feature.add_$feature"); ?>
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th>Action</th>
            <?php 
                foreach($fields as $field){
                    if($field == 'id') continue;
            ?>
                <th><?=humanize($field);?></th>
            <?php 
                }
            ?>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
</div>