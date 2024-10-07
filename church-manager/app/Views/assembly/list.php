<?php
// log_message('error',json_encode($result));
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script> -->

<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='entypo-bell'></i>
            <?= lang('assembly.list_assemblies'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary'
            onclick="showAjaxModal('<?= plural($feature); ?>','add', '<?= session()->get('user_denomination_id') ? hash_id(session()->get('user_denomination_id'), 'encode') : ''; ?>')">
            <?= lang('assembly.add_assembly'); ?>
        </div>
    </div>
</div>

<div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('assembly.assembly_action') ?></th>
                    <th><?= lang('assembly.assembly_name') ?></th>
                    <th><?= lang('assembly.assembly_planted_at') ?></th>
                    <th><?= lang('assembly.assembly_location') ?> </th>
                    <th><?= lang('assembly.assembly_entity_id') ?></th>
                    <th><?= lang('assembly.assembly_leader') ?></th>
                    <th><?= lang('assembly.assembly_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $assembly) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <a href="<?= site_url("assemblies/view/" . hash_id($assembly['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i>
                            </span>
                            <span class='action-icons'>
                                <i style="cursor:pointer"
                                    onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($assembly['id']); ?>')"
                                    class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons'
                                onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($assembly['id']); ?>')"
                                title="Delete <?= $assembly['id']; ?> participant"><i class='fa fa-trash'></i></span>
                        </td>
                        <!-- 
                    <td><?= $assembly['name']; ?></td>
                    <td><?= $assembly['planted_at']; ?></td>
                    <td><?= $assembly['location']; ?></td>
                    <td><?= $assembly['entity_name']; ?></td>
                    <td><?= $assembly['assembly_leader'] ? $assembly['assembly_leader'] : lang('system.value_not_set'); ?></td>
                    <td><?= ucfirst($assembly['is_active']); ?></td> -->

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('assemblies/fetchAssemblies') ?>",
                "type": "POST"
            },
            "columns": [{
                    data: null,
                    "render": function(data, type, row) {
                        return '<span class="action-icons">\
                            <a href="' + "<?= site_url("assemblies/view/" . hash_id($assembly['id'])); ?>" + row.id + '"><i class="fa fa-search"></i></a>\ </span>\
                          <span class="action-icons">\
              <i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\',\'edit\', \'' + row.id + '\')" class="fa fa-pencil"></i>\
            </span>\
            <span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\',\'delete\', \'' + row.id +
                            '\')" title="Delete' + row.id +
                            'participant"><i class="fa fa-trash"></i></span>';
                    }
                },
                
                {
                    data: "name"
                },
                {
                    data: "planted_at"
                },
                {
                    data: "location"
                },
                {
                    data: "entity_id"
                },
                {
                    data: "assembly_leader"
                },
                {
                    data: "is_active"
                },

                // { "data": function (d) {
                //     d.denomination_id  = "<?php echo session()->get('user_denomination_id') ? hash_id(session()->get('user_denomination_id'), 'encode') : ''; ?>";
                // }},

            ]
        })
    })
</script>