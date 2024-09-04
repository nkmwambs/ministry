<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('departments','add', '<?= $id; ?>')">
            <?= lang('department.add_department'); ?>
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
                    <th><?= lang('department.department_ction') ?></th>
                    <th><?= lang('department.department_name') ?></th>
                    <th><?= lang('department.department_description') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $department) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $department['id']; ?> participant"><a href="<?= site_url("participants/view/" . hash_id($department['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i></span>
                            <span class='action-icons' title="Edit <?= $department['id']; ?> participant">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($department['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= $department['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $department['member_id']; ?></td>
                        <td><?= $department['payment_id']; ?></td>
                        <td><?= $department['payment_code']; ?></td>
                        <td><?= $department['registration_amount']; ?></td>
                        <td><?= $department['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>