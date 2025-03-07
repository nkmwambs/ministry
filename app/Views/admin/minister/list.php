<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('ministers','add', '<?= $parent_id; ?>')">
            <?= lang('minister.add_minister'); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction('ministers','delete')">
            <i class="fa fa-trash-o"></i>
            <?= lang('minister.delete_ministers'); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction('ministers','edit')">
            <i class="fa fa-pencil-square-o"></i>
            <?= lang('minister.edit_ministers'); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction('ministers','view')">
            <i class="fa fa-eye"></i>
            <?= lang('minister.view_ministers'); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction('ministers','print')">
            <i class="fa fa-print"></i>
            <?= lang('minister.print_ministers'); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction('ministers','export')">
            <i class="fa fa-download"></i>
            <?= lang('minister.export_ministers'); ?>
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
                    <th><?= lang('minister.minister_action') ?></th>
                    <th><?= lang('minister.minister_number') ?></th>
                    <th><?= lang('minister.member_first_name') ?></th>
                    <th><?= lang('minister.member_last_name') ?></th>
                    <th><?= lang('minister.license_number') ?></th>
                    <th><?= lang('minister.member_designation') ?></th>
                    <th><?= lang('minister.member_phone') ?></th>
                    <th><?= lang('minister.minister_assembly_id') ?></th>
                    <th><?= lang('minister.minister_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $minister) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <input type="checkbox" class = "select_item" name="item_id[]" value="<?php echo $minister['id'];?>">
                            </span>
                        </td>
                        <td>
                        <div class="btn-group">
								<button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown">
									Action <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-blue" role="menu">
									<li>
                                        <a href="#" onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($minister['id']);?>')" >View</a>
									</li>
                                    <li class="divider"></li>
									<li>
                                        <a href="#" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($minister['id']); ?>')">Edit</a>
									</li>
									<li class="divider"></li>
									<li>
                                        <a href="#" onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($minister['id']); ?>')">Delete</a>
									</li>
								</ul>
							</div>
                        </td>

                        <td><?= $minister['minister_number']; ?></td>
                        <td><?= $minister['member_first_name']; ?></td>
                        <td><?= $minister['member_last_name']; ?></td>
                        <td><?= $minister['license_number']; ?></td>
                        <td><?= $minister['designation_name']; ?></td>
                        <td><?= $minister['member_phone']; ?></td>
                        <td><?= $minister['assembly_name']; ?></td>
                        <td><?= $minister['is_active']; ?></td>
                    
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