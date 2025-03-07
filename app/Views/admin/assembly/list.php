<?php 
$tableName = "assemblies";
$feature = "assembly";
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal($tableName,'add', '<?= $parent_id; ?>')">
            <?= lang($feature.'.add_'.$feature); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($tableName,'delete')">
            <i class="fa fa-trash-o"></i>
            <?= lang($feature.'.delete_'.$tableName); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($tableName,'edit')">
            <i class="fa fa-pencil-square-o"></i>
            <?= lang($feature.'.edit_'.$tableName); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($tableName,'view')">
            <i class="fa fa-eye"></i>
            <?= lang($feature.'.view_'.$tableName); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($tableName,'print')">
            <i class="fa fa-print"></i>
            <?= lang($feature.'.print_'.$tableName); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($tableName,'export')">
            <i class="fa fa-download"></i>
            <?= lang($feature.'.export_'.$tableName); ?>
        </div>
    </div>
</div>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select_all" ></th>
                    <th><?= lang($feature.'.'.$feature.'_action') ?></th>
                    <th><?= lang($feature.'.assembly_name') ?></th>
                    <th><?= lang($feature.'assembly_code') ?></th>
                    <th><?= lang($feature.'.assembly_planted_at') ?></th>
                    <th><?= lang($feature.'.assembly_location') ?> </th>
                    <th><?= lang($feature.'.assembly_entity_id') ?></th>
                    <th><?= lang($feature.'.assembly_leader') ?></th>
                    <th><?= lang($feature.'.assembly_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $item) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <input type="checkbox" class = "select_item" name="item_id[]" value="<?php echo $item['id'];?>">
                            </span>
                        </td>
                        <td>
                        <div class="btn-group">
								<button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
									Action <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-blue" role="menu">
									<li>
                                        <a href="#" onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($item['id']);?>')" >View</a>
									</li>
                                    <li class="divider"></li>
									<li>
                                        <a href="#" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($item['id']); ?>')">Edit</a>
									</li>
									<li class="divider"></li>
									<li>
                                        <a href="#" onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($item['id']); ?>')">Delete</a>
									</li>
								</ul>
							</div>
                        </td>

                        <td><?= $item['name']; ?></td>
                        <td><?= $item['assembly_code']; ?></td>
                        <td><?= $item['planted_at']; ?></td>
                        <td><?= $item['location']; ?></td>
                        <td><?= $item['entity_name']; ?></td>
                        <td><?= $item['assembly_leader']; ?></td>
                        <td><?= $item['is_active']; ?></td>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>

    $('#select_all').click(function(){
        $('.select_item').prop('checked', $(this).prop('checked'));
    });

    $(".select_item, #select_all").on('change', function(){
        // Show mass_action buttons if checked 
        if($('.select_item:checked').length > 0){
            $('.mass_action').removeClass('hidden');
        } else {
            $('.mass_action').addClass('hidden');
        }

        // If .select_item are all unchecked also uncheck #select_all
        if($('.select_item:checked').length === 0){
            $('#select_all').prop('checked', false);
        }
    })

    function bulkAction(tableName, actionOnItem){
        var selectedItems = [];
        $('.select_item:checked').each(function(i, el){
            selectedItems.push($(el).val());
        });
        
        showAjaxBulkAction(tableName, actionOnItem, selectedItems)
    }


</script>