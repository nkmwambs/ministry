<!-- <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
      <?= lang('visitor.list_visitors'); ?>
      </div>
    </div>
  </div> -->

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('visitors','add', '<?= $id; ?>')">
            <?= lang('visitor.add_visitor'); ?>
        </div>
        <?php if (!empty($result)) { ?>
            <!-- <div class='btn btn-primary' onclick="showAjaxModal('entities','add', '<?= $id; ?>')">
              <?= lang('entity.add_entity'); ?>
        </div> -->
        <?php } ?>
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
                    <th><?= lang('visitor.visitor_payment_id') ?></th>
                    <th><?= lang('visitor.visitor_payment_code') ?></th>
                    <th><?= lang('visitor.visitor_registration_amount') ?></th>
                    <th><?= lang('visitor.visitor_status') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $collection) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $collection['first_name']; ?> visitor"><a href="<?= site_url("visitors/view/" . hash_id($collection['id'])); ?>"><i
                                        class='fa fa-search'></i></a></i></span>
                            <span class='action-icons' title="Edit <?= $collection['first_name']; ?> visitor">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($collection['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete <?= $collection['first_name']; ?> visitor"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $collection['first_name']; ?></td>
                        <td><?= $collection['last_name']; ?></td>
                        <td><?= $collection['phone']; ?></td>
                        <td><?= $collection['email']; ?></td>
                        <td><?= $collection['gender']; ?></td>
                        <td><?= $collection['date_of_birth']; ?></td>
                        <td><?= $collection['payment_id']; ?></td>
                        <td><?= $collection['payment_code']; ?></td>
                        <td><?= $collection['registration_amount']; ?></td>
                        <td><?= $collection['status']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>