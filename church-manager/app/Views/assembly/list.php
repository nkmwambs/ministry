<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('assembly.list_assemblies'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?=plural($feature);?>','add')">
            <?= lang('assembly.add_assembly'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
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
                <?php foreach($result as $assembly){?>
                <tr>
                    <td>
                        <span class='action-icons'>
                            <a href="<?= site_url("assemblies/view/".hash_id($assembly['id'])); ?>"><i
                                    class='fa fa-search'></i></a></i>
                        </span>
                        <span class='action-icons'>
                            <i style="cursor:pointer"
                                onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($assembly['id']);?>')"
                                class='fa fa-pencil'></i>
                        </span>
                        <span class='action-icons'>
                            <i class='fa fa-trash'></i>
                        </span>
                    </td>

                    <td><?=$assembly['name'];?></td>
                    <td><?=$assembly['planted_at'];?></td>
                    <td><?=$assembly['location'];?></td>
                    <td><?=$assembly['entity_id'];?></td>
                    <td><?=$assembly['assembly_leader'];?></td>
                    <td><?=$assembly['is_active'];?></td>
                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>