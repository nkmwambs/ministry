  <?php if(!$number_of_denomination_assemblies){
    echo button_row($feature, $parent_id);
  } ?>

  <div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th><?= lang('hierarchy.hierarchy_action') ?></th>
            <th><?= lang('hierarchy.hierarchy_name') ?></th>
            <th><?= lang('hierarchy.hierarchy_code') ?></th>
            <th><?= lang('hierarchy.hierarchy_description') ?></th>
            <th><?= lang('hierarchy.hierarchy_level') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $hierarchy){?>
            <tr>
              <td>
                <span class='action-icons' title="View <?=singular($hierarchy['name']);?> hierarchy">
                    <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($hierarchy['id']);?>')"></i>
                </span>
                <span class='action-icons' title = "Edit <?=singular($hierarchy['name']);?> hierarchy">
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($hierarchy['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($hierarchy['id']); ?>')" title="Delete <?= $hierarchy['id']; ?> participant"><i class='fa fa-trash'></i></span>
                <?php if($hierarchy['level'] != 1) {?>
                  <!-- <span onclick="showAjaxListModal('entities','list', '<?=hash_id($hierarchy['id'], 'encode');?>')" class='action-icons' title = "List <?=plural($hierarchy['name']);?>"><i class='fa fa-plus'></i></span> -->
                <?php }?>
              </td>

              <td><?=$hierarchy['name'];?></td>
              <td><?=$hierarchy['hierarchy_code'];?></td>
              <td><?=$hierarchy['description'];?></td>
              <td><?=$hierarchy['level'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
