  <!-- <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('hierarchy.list_hierarchies'); ?>
      </div>
    </div>
  </div> -->

  <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('hierarchies','add', '<?=$id;?>')">
            <?= lang('hierarchy.add_hierarchy'); ?>
      </div>
      <?php if(!empty($result)) {?>
        <!-- <div class='btn btn-primary' onclick="showAjaxModal('entities','add', '<?=$id;?>')">
              <?= lang('entity.add_entity'); ?>
        </div> -->
      <?php }?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th>Action</th>
            <th>Name</th>
            <th>Description</th>
            <th>Level</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $hierarchy){?>
            <tr>
              <td>
                <span class='action-icons' title="View <?=singular($hierarchy['name']);?> hierarchy"><a href="<?= site_url("hierarchies/view/".hash_id($hierarchy['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons' title = "Edit <?=singular($hierarchy['name']);?> hierarchy">
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($hierarchy['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' title = "Delete <?=singular($hierarchy['name']);?> hierarchy"><i class='fa fa-trash'></i></span>
                <?php if($hierarchy['level'] != 1) {?>
                  <span onclick="showAjaxListModal('entities','list', '<?=hash_id($hierarchy['id'], 'encode');?>')" class='action-icons' title = "List <?=plural($hierarchy['name']);?>"><i class='fa fa-plus'></i></span>
                <?php }?>
              </td>

              <td><?=$hierarchy['name'];?></td>
              <td><?=$hierarchy['description'];?></td>
              <td><?=$hierarchy['level'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
