<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('designations','add', '<?= $parent_id ?>')">
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
                    <th><?= lang('designation.designation_action') ?></th>
                    <th><?= lang('designation.designation_name') ?></th>
                    <th><?= lang('designation.denomination_id') ?></th>
                    <th><?= lang('designation.is_hierarchy_leader_designation') ?></th>
                    <th><?= lang('designation.is_department_leader_designation') ?></th>
                    <th><?= lang('designation.is_minister_title_designation') ?></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $designation) { ?>
                <tr>
                <td>
                        <span class='action-icons' title="View <?=singular($designation['name']);?> designation">
                            <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($designation['id']);?>')"></i>
                        </span>
                        <span class='action-icons' title="Edit <?= $designation['id']; ?> designation">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($designation['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($designation['id']); ?>')" title="Delete <?= $designation['id']; ?> designation"><i class='fa fa-trash'></i></span>

                        </td>

                    <td><?= $designation['name']; ?></td>
                    <td><?= $designation['denomination_name']; ?></td>
                    <td><?= $designation['is_hierarchy_leader_designation']; ?></td>
                    <td><?= $designation['is_department_leader_designation']; ?></td>
                    <td><?= $designation['is_minister_title_designation']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <script>
$(document).ready(function (){
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('designations/fetchDesignations')?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="<?= site_url("designations/view/") ?>' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' designation"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "name" },
            { data: "denomination_id" },
            { data: "is_hierarchy_leader_designation" },
            { data: "is_department_leader_designation" },
            { data: "is_minister_title_designation" },
        ]
    });
});
</script> -->