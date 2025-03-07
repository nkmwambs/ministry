<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('tithes','add', '<?= $parent_id; ?>')">
            <?= lang('tithe.add_tithe'); ?>
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
                    <th><?= lang('tithe.tithe_action') ?></th>
                    <th><?= lang('tithe.tithe_member_first_name') ?></th>
                    <th><?= lang('tithe.tithe_member_last_name') ?></th>
                    <th><?= lang('tithe.tithing_date') ?></th>
                    <th><?= lang('tithe.tithe_amount') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $tithe) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $tithe['member_first_name'].' '.$tithe['member_last_name']; ?> tithe">
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($tithe['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $tithe['member_first_name'].' '.$tithe['member_last_name']; ?> tithe">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($tithe['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($tithe['id']); ?>')" title="Delete <?= $tithe['member_first_name'].' '.$tithe['member_last_name']; ?> tithe"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $tithe['member_first_name']; ?></td>
                        <td><?= $tithe['member_last_name']; ?></td>
                        <td><?= $tithe['tithing_date']; ?></td>
                        <td><?= $tithe['amount']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>
