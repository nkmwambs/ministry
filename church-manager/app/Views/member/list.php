<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('member.list_members'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('members','add', '<?=$id;?>')">
            <?= lang('member.add_member'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Member Number</th>
                    <th>Designation ID</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>is_active</th>
                    <th>Assembly ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $member){?>
                <tr>
                    <td>
                        <span class='action-icons' title="View <?=singular($member['first_name']);?> member">
                            <a href="<?= site_url("members/view/".hash_id($member['id'])); ?>"><i
                                    class='fa fa-search'></i></a>
                        </span>
                        <span class='action-icons' title="Edit <?=singular($member['first_name']);?> member">
                            <i style="cursor:pointer"
                                onclick="showAjaxModal('members','edit', '<?=hash_id($member['id']);?>')"
                                class='fa fa-pencil'></i>
                        </span>
                        <span class='action-icons' title="Delete <?=singular($member['first_name']);?> member">
                            <i class='fa fa-trash'></i>
                        </span>
                    </td>
                    <td><?=$member['first_name'];?></td>
                    <td><?=$member['last_name'];?></td>
                    <td><?=$member['member_number'];?></td>
                    <td><?=$member['designation_id'];?></td>
                    <td><?=$member['date_of_birth'];?></td>
                    <td><?=$member['email'];?></td>
                    <td><?=$member['phone'];?></td>
                    <td><?=$member['is_active'];?></td>
                    <td><?=$member['assembly_id'];?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>