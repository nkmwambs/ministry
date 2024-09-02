<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('visitor.list_visitors'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('visitors','add', '<?= $id; ?>')">
            <?= lang('visitor.add_visitor'); ?>
        </div>
        <!-- <?php if (!empty($result)) { ?>
        <div class='btn btn-primary' onclick="showAjaxModal('entities','add', '<?= $id; ?>')">
              <?= lang('entity.add_entity'); ?>
        </div>
      <?php } ?> -->
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
                    <th><?= lang('visitor.visitor_action') ?></th>
                    <th><?= lang('visitor.visitor_first_name') ?></th>
                    <th><?= lang('visitor.visitor_last_name') ?></th>
                    <th><?= lang('visitor.visitor_phone') ?></th>
                    <th><?= lang('visitor.visitor_email') ?></th>
                    <th><?= lang('visitor.visitor_date_of_birth') ?></th>
                    <th><?= lang('visitor.visitor_event_id') ?></th>
                    <th><?= lang('visitor.visitor_payment_id') ?></th>
                    <th><?= lang('visitor.visitor_payment_code') ?></th>
                    <th><?= lang('visitor.visitor_registration_amount') ?></th>
                    <th><?= lang('visitor.visitor_status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $visitor) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= singular($visitor['name']); ?> visitor"><a href="<?= site_url("visitors/view/" . hash_id($visitor['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i>
                            </span>
                            <span class='action-icons' title="Edit <?= singular($visitor['name']); ?> visitor">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($visitor['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= singular($visitor['name']); ?> visitor"><i class='fa fa-trash'></i></span>
                            <?php if ($visitor['level'] != 1) { ?>
                                <span onclick="showAjaxListModal('entities','list', '<?= hash_id($visitor['id'], 'encode'); ?>')" class='action-icons' title="List <?= plural($visitor['name']); ?>"><i class='fa fa-plus'></i></span>
                            <?php } ?>
                        </td>

                        <td><?= $visitor['first_name']; ?></td>
                        <td><?= $visitor['last_name']; ?></td>
                        <td><?= $visitor['phone']; ?></td>
                        <td><?= $visitor['email']; ?></td>
                        <td><?= $visitor['gender']; ?></td>
                        <td><?= $visitor['date_of_birth']; ?></td>
                        <td><?= $visitor['event_id']; ?></td>
                        <td><?= $visitor['payment_id']; ?></td>
                        <td><?= $visitor['payment_code']; ?></td>
                        <td><?= $visitor['registration_amount']; ?></td>
                        <td><?= $visitor['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>