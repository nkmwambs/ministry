<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-calendar'></i>
            <?= lang('event.list_events'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?= plural($feature); ?>','add')">
            <?= lang('event.add_event'); ?>
        </div>
    </div>
</div>

<div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th><?= lang('event.event_action') ?></th>
                    <th><?= lang('event.event_name') ?></th>
                    <th><?= lang('event.event_meeting_id') ?></th>
                    <th><?= lang('event.event_start_date') ?></th>
                    <th><?= lang('event.event_end_date') ?></th>
                    <th><?= lang('event.event_location') ?></th>
                    <th><?= lang('event.event_description') ?></th>
                    <th><?= lang('event.event_denomination_id') ?></th>
                    <th><?= lang('event.event_registration_fees') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $event) { ?>
                    <tr>
                        <td>
                            <span class='action-icons'>
                                <a href="<?= site_url("events/view/" . hash_id($event['id'])); ?>"><i class='fa fa-search'></i></a></i>
                            </span>
                            <span class='action-icons'>
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($event['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons'>
                                <i class='fa fa-trash'></i>
                            </span>
                        </td>

                        <td><?= $event['name']; ?></td>
                        <td><?= $event['meeting_id']; ?></td>
                        <td><?= $event['start_date']; ?></td>
                        <td><?= $event['end_date']; ?></td>
                        <td><?= $event['location']; ?></td>
                        <td><?= $event['description']; ?></td>
                        <td><?= $event['denomination_id']; ?></td>
                        <td><?= $event['registration_fees']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>