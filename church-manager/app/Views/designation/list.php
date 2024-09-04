<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('designation','add', '<?= $id; ?>')">
            <?= lang('designation.add_designation'); ?>
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
                    <th><?= lang('designation.designation_ction') ?></th>
                    <th><?= lang('designation.designation_name') ?></th>
                    <th><?= lang('designation.designation_description') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $department) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $designation['id']; ?> participant"><a href="<?= site_url("participants/view/" . hash_id($designation['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i></span>
                            <span class='action-icons' title="Edit <?= $designation['id']; ?> participant">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($designation['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= $designation['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $designation['member_id']; ?></td>
                        <td><?= $designation['payment_id']; ?></td>
                        <td><?= $designation['payment_code']; ?></td>
                        <td><?= $designation['registration_amount']; ?></td>
                        <td><?= $designation['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>