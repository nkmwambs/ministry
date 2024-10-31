<div class="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang("$designation.list_".plural($designation)); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <a href="<?= site_url(plural($designation)."/add"); ?>" class='btn btn-primary'>
      <!-- <a href="<?= site_url("modal/load/$designation/add"); ?>" class='btn btn-primary'> -->
        <?= lang("$designation.add_$designation"); ?>
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