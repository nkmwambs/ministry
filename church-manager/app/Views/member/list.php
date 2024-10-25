<?=button_row($feature);?>

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
                    <th><?= lang('member.member_action') ?></th>
                    <th><?= lang('member.member_first_name') ?></th>
                    <th><?= lang('member.member_last_name') ?></th>
                    <th><?= lang('member.member_gender') ?></th>
                    <th><?= lang('member.member_member_number') ?></th>
                    <th><?= lang('member.member_designation_id') ?></th>
                    <th><?= lang('member.member_assembly_name') ?></th>
                    <th><?= lang('member.member_date_of_birth') ?></th>
                    <th><?= lang('member.member_phone') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $member) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <input type="checkbox" class = "select_item" name="item_id[]" value="<?php echo $member['id'];?>">
                            </span>
                        </td>
                        <td>
                            <span class='action-icons' title="View <?=singular($member['first_name']);?> member">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($member['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $member['first_name']; ?> member">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($member['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($member['id']); ?>')" title="Delete <?= $member['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $member['first_name']; ?></td>
                        <td><?= $member['last_name']; ?></td>
                        <td><?= $member['gender']; ?></td>
                        <td><?= $member['member_number']; ?></td>
                        <td><?= $member['designation_name']; ?></td>
                        <td><?= $member['assembly_name']; ?></td>
                        <td><?= $member['date_of_birth']; ?></td>
                        <td><?= $member['phone']; ?></td>

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