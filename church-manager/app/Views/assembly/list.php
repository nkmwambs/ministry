<?php 
// log_message('error',json_encode($result));
?>

<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='entypo-bell'></i>
            <?= lang('assembly.list_assemblies'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?=plural($feature);?>','add', '<?=session()->get('user_denomination_id') ? hash_id(session()->get('user_denomination_id'), 'encode') : '';?>')">
            <?= lang('assembly.add_assembly'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
  </div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('assembly.assembly_action') ?></th>
                    <th><?= lang('assembly.assembly_name') ?></th>
                    <th><?= lang('assembly.assembly_code') ?></th>
                    <th><?= lang('assembly.assembly_planted_at') ?></th>
                    <th><?= lang('assembly.assembly_location') ?> </th>
                    <th><?= lang('assembly.assembly_entity_id') ?></th>
                    <th><?= lang('assembly.assembly_leader') ?></th>
                    <th><?= lang('assembly.assembly_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function (){
    $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo site_url('assemblies/fetchAssemblies')?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="<?= site_url("assemblies/view/") ?>' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' assembly"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "name" },
            { data: "assembly_code" },
            { data: "planted_at" },
            { data: "location" },
            { data: "entity_name" },
            { data: "assembly_leader" },
            { data: "is_active" }
        ]
    });
});
</script>
