<?php 
// echo $parent_id;
?>

  <div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('entities','add', '<?=$parent_id;?>')">
              <?= lang('entity.add_entity'); ?>
        </div>
    </div>
  </div>

  <div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable<?=$parent_id;?>">
        <thead>
          <tr>
            <th>Action</th>
            <th>Entity Number</th>
            <th>Name</th>
            <th>Belongs To</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $entity){?>
            <tr>
              <td>
                <span class='action-icons' title="View <?=singular($entity['entity_name']);?> hierarchy">
                  <!-- <a href="<?= site_url("entities/view/".hash_id($entity['id'])); ?>"> -->
                    <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($designation);?>','view', '<?=hash_id($entity['id']);?>')"></i>
                  <!-- </a> -->
                </span>
                <span class='action-icons' title = "Edit <?=singular($entity['entity_name']);?> hierarchy">
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($designation);?>','edit', '<?=hash_id($entity['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' onclick="deleteItem('<?= plural($designation); ?>','delete','<?= hash_id($entity['id']); ?>')" title="Delete <?= $entity['id']; ?> participant"><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$entity['entity_number'];?></td>
              <td><?=$entity['entity_name'];?></td>
              <td><?=$entity['parent_name'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const parent_id = "<?=$parent_id;?>"

    $(document).ready(function() {
      $('.datatable'+parent_id).DataTable({
        stateSave: true
      });
    });
  </script>