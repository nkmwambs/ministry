<!-- <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('entity.list_entities'); ?>
      </div>
    </div>
  </div> -->

  <!-- <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('entities','add', '<?=$id;?>')">
            <?= lang('entity.add_entity'); ?>
        </div>
    </div>
  </div> -->

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th>Action</th>
            <th>Entity Number</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $entity){?>
            <tr>
              <td>
                <span class='action-icons' title="View <?=singular($entity['name']);?> hierarchy"><a href="<?= site_url("entities/view/".hash_id($entity['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons' title = "Edit <?=singular($entity['name']);?> hierarchy">
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($entity['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' title = "Delete <?=singular($entity['name']);?> hierarchy"><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$entity['entity_number'];?></td>
              <td><?=$entity['name'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
