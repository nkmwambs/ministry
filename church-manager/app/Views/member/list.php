<?php 
// print_r($parent_id);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('members','add', '<?= $parent_id; ?>')">
            <?= lang('member.add_member'); ?>
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
                    <th><?= lang('member.member_action') ?></th>
                    <th><?= lang('member.member_first_name') ?></th>
                    <th><?= lang('member.member_last_name') ?></th>
                    <th><?= lang('member.member_member_number') ?></th>
                    <th><?= lang('member.member_designation_id') ?></th>
                    <th><?= lang('member.member_date_of_birth') ?></th>
                    <th><?= lang('member.member_email') ?></th>
                    <th><?= lang('member.member_phone') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $member) { ?>
                    <tr>
                        <td>
                            <span class='action-icons' title="View <?= $member['first_name']; ?> member">
                                <!-- <a href="<?= site_url("members/view/" . hash_id($member['id'])); ?>">
                                <i class='fa fa-search'></i> -->
                                <i class='fa fa-search' onclick="showAjaxListModal('<?= plural($designation); ?>','view', '<?= hash_id($member['id']); ?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $member['first_name']; ?> member">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($designation); ?>','edit', '<?= hash_id($member['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($designation); ?>','delete','<?= hash_id($member['id']); ?>')" title="Delete <?= $member['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <td><?= $member['first_name']; ?></td>
                        <td><?= $member['last_name']; ?></td>
                        <td><?= $member['member_number']; ?></td>
                        <td><?= $member['designation_id']; ?></td>
                        <td><?= $member['date_of_birth']; ?></td>
                        <td><?= $member['email']; ?></td>
                        <td><?= $member['phone']; ?></td>

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>