<?php 
// echo $parent_id;
?>

  <div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('entities''','add', '<?=$parent_id;?>')">
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
      <table class="table table-striped " id="entity_dataTable" <?=$parent_id;?>>
        <thead>
          <tr>
            <?php 
              foreach($result as $column){
              ?>
                  <th><?= lang($column) ?></th>
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

<script>
$(document).ready(function() {
    $('#entity_dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo site_url('denominations/fetchEntities/'.$parent_id); ?>",
            type: "POST"
        },
        columns: [
            // { data: 'id' },
            // <?php 
            // foreach($result as $column){
            //     echo "{ data: '". $column. "' },";
            // }
            // ?>,
            // { data: 'action', searchable: true, orderable: false },
            {data:null, "render": function(data, type, row){
              return `
            <span class="action-icons">
                <a href="<?= site_url("entities/view/") ?>">
                    <i class="fa fa-search"></i>
                </a>
            </span>
            <span class="action-icons">
                <i style="cursor:pointer" onclick="showAjaxModal('${row.feature_plural}', 'edit', '${row.hash_id}')" class="fa fa-pencil"></i>
            </span>
            <span class="action-icons" onclick="deleteItem('${row.feature_plural}', 'delete', '${row.hash_id}')" title="Delete ${row.hash_id} participant">
                <i class="fa fa-trash"></i>
            </span>`;

            }},
            {data:"entity_number"},
            {data:"entity_name"},
            {data:"parent_name"},
        ],
    })
});

</script>