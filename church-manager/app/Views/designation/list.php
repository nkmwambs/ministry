<!-- <div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('designation','add', '<?= $id; ?>')">
            <?= lang('designation.add_designation'); ?>
        </div>
    </div>
</div> -->

<?php 
    if(!session()->get('user_denomination_id')){
  ?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?=plural($feature);?>','add')">
            <?= lang('designation.add_designation'); ?>
        </div>
    </div>
</div>
<?php 
    }
?>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><?= lang('designation.designation_action') ?></th>
                    <th><?= lang('designation.designation_name') ?></th>
                    <th><?= lang('designation.denomination_id') ?></th>
                    <th><?= lang('designation.designation.hierarchy_id') ?></th>
                    <th><?= lang('designation.department_id') ?></th>
                    <th><?= lang('designation.minister_title_designation') ?></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $designation) { ?>
                <tr>
                <td>
                        <span class='action-icons' title="View <?= $designation['id']; ?> designation">
                            
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($designation['id']);?>')"></i>
                        </span>
                        <span class='action-icons' title="Edit <?= $designation['id']; ?> designation">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($designation['id']); ?>')" class='fa fa-pencil'></i>
                        </span>
                        <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($designation['id']); ?>')" title="Delete <?= $designation['id']; ?> designation"><i class='fa fa-trash'></i></span>

                </td>

                    <td><?= $designation['name']; ?></td>
                    <td><?= $designation['denomination_id']; ?></td>
                    <td><?= $designation['hierarchy_id']; ?></td>
                    <td><?= $designation['department_id']; ?></td>
                    <td><?= $designation['minister_title_designation']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>
