<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('meetings','add', '<?= $parent_id ?>')">
            <?= lang('meeting.add_meeting'); ?>
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
                    <th><?= lang('meeting.meeting_action') ?></th>
                    <th><?= lang('meeting.meeting_name') ?></th>
                    <th><?= lang('meeting.meeting_description') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $meeting) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $meeting['id']; ?> meeting">
                                <!-- <a href="<?= site_url("meetings/view/" . hash_id($meeting['id'])); ?>">
                                    <i class='fa fa-search'></i>
                                </a> -->
                                <i class='fa fa-search' onclick="showAjaxListModal('<?=plural($feature);?>','view', '<?=hash_id($meeting['id']);?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $meeting['id']; ?> meeting">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($meeting['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= $meeting['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $meeting['name']; ?></td>
                        <td><?= $meeting['description']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
