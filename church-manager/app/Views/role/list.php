<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('roles','add','<?= $parent_id ?>')">
            <?= lang('role.add_role'); ?>
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
                    <th><?= lang('role.role_action') ?></th>
                    <th><?= lang('role.role_name') ?></th>
                    <th><?= lang('role.role_default') ?></th>
                    <th><?= lang('role.role_denomination_name') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $role) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $role['id']; ?> role">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($role['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $role['id']; ?> role">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($role['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($role['id']); ?>')" title="Delete <?= $role['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $role['name']; ?></td>
                        <td><?= $role['default_role']; ?></td>
                        <td><?= $role['denomination_id']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
