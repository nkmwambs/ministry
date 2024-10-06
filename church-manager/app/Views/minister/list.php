<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>


<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('minister.list_ministers'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?= plural($feature); ?>','add')">
            <?= lang('minister.add_minister'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped " id="dataTable">
            <thead>
                <tr>
                    <th><?= lang('minister.minister_action_col') ?></th>
                    <th><?= lang('minister.minister_name') ?></th>
                    <th><?= lang('minister.minister_number') ?></th>
                    <th><?= lang('minister.minister_assembly_id') ?></th>
                    <th><?= lang('minister.minister_designation_id') ?></th>
                    <th><?= lang('minister.minister_phone') ?></th>
                    <th><?= lang('minister.minister_is_active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $minister) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <a href="<?= site_url("ministers/view/" . hash_id($minister['id'])); ?>"><i class='fa fa-search'></i></a></i>
                            </span>
                            <span class='action-icons'>
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($minister['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($minister['id']); ?>')" title="Delete <?= $minister['id']; ?> participant"><i class='fa fa-trash'></i></span>
                        </td>

                        <!-- <td><?= $minister['name']; ?></td>
                        <td><?= $minister['minister_number']; ?></td>
                        <td><?= $minister['assembly_id']; ?></td>
                        <td><?= $minister['designation_id']; ?></td>
                        <td><?= $minister['phone']; ?></td>
                        <td><?= $minister['is_active']; ?></td> -->

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
                "url": "<?= site_url('ministers/fetchMinisters')?>",
                "type": "POST"
            },
            "column": [
                { "data": null, "render": function(data, type, row){
                    return "<span class='action-icons'><a href='" + "<?php echo site_url('ministers/view/');?>"+btoa(row.id) + "'><i class='fa fa-search'></i></a></span>" +
                            "<span class='action-icons'><i style='cursor:pointer' onclick='showAjaxModal('"+plural($feature)+"','edit', btoa(row.id))' class='fa fa-pencil'></i></span>" +
                            "<span class='action-icons' onclick='deleteItem('"+plural($feature)+"','delete', btoa(row.id))' title='Delete "+row.id+" participant'><i class='fa fa-trash'></i></span>";
                 
                }},
                { "data": "name" },
                { "data": "minister_number" },
                { "data": "assembly_id" },
                { "data": "designation_id" },
                { "data": "phone" },
                { "data": "is_active" }
             ],
            
        });
    });
</script>