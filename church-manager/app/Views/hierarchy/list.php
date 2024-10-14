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
      <table class="table table-striped " id="hierarchy_dataTable">
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
    $('#hierarchy_dataTable').DataTable({
      processing: true,
      serverSide: true,
      saveState : true,
      ajax: {
        url: "<?php echo base_url('denominations/fetchHierarchies/'.$parent_id)?>",
        type: "POST"
      },

      "columns":  [
        { data: "id", render: function (data, type, row){
          return    `<span class='action-icons' title="View ${row.name} hierarchy">
                    <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', ${row.id})"></i>
                </span>
                <span class='action-icons' title = "Edit ${row.name} hierarchy">
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', ${row.id})" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete', ${row.id})" title="Delete ${row.id} participant"><i class='fa fa-trash'></i></span> `;
          
        } },
        { data: "name" },
        { data: "hierarchy_code" },
        { data: "description" },
        { data: "level" }] 
    });
  } );
</script>