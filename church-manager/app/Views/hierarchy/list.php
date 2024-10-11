  <?php 
  
  if(!$number_of_denomination_assemblies){
  ?>
  <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('hierarchies','add', '<?=$parent_id;?>')">
            <?= lang('hierarchy.add_hierarchy'); ?>
      </div>
    </div>
  </div>
<?php 
  }
?>
  <div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped " id="dataTable">
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

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
$(document).ready(function (){
  
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('denominations/fetchHierarchies/'.$parent_id)?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                  return `<span class='action-icons' title="View <?=singular($hierarchy['name']);?> hierarchy">
            <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($hierarchy['id']);?>')"></i>
          </span>
          <span class='action-icons' title="Edit <?=singular($hierarchy['name']);?> hierarchy">
            <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($hierarchy['id']);?>')" class='fa fa-pencil'></i>
          </span>
          <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($hierarchy['id']); ?>')" title="Delete <?= $hierarchy['id']; ?> participant">
            <i class='fa fa-trash'></i>
          </span>`;
                }
            },
            { data: "name" },
            { data: "hierarchy_code" },
            { data: "description" },
            { data: "level" }
        ]
    });
});
</script>
