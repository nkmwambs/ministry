<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

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
        <table class="table table-striped " id ="dataTables">
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
                                <i class='fa fa-search' onclick="showAjaxListModal('<?= plural($feature); ?>','view', '<?= hash_id($member['id']); ?>')"></i>
                            </span>
                            <span class='action-icons' title="Edit <?= $member['first_name']; ?> member">
                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($member['id']); ?>')" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($member['id']); ?>')" title="Delete <?= $member['id']; ?> participant"><i class='fa fa-trash'></i></span>

                        </td>

                        <!-- <td><?= $member['first_name']; ?></td>
                        <td><?= $member['last_name']; ?></td>
                        <td><?= $member['member_number']; ?></td>
                        <td><?= $member['designation_id']; ?></td>
                        <td><?= $member['date_of_birth']; ?></td>
                        <td><?= $member['email']; ?></td>
                        <td><?= $member['phone']; ?></td> -->

                    <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    //Datatables server Side rendering
    $(document).ready(function() {
        $('#dataTables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo site_url('members/fetchMembers/')?>", //+ $parent_id,
                type: "POST"
            },
            "columns": [
                { data: null, "render": function( data, type, row) {

                    return '<span class="action-icons" title="View'+ data.first_name +' member">' +
                        '<i class="fa fa-search" onclick="showAjaxListModal(\'' + plural(feature) + '\',\'view\', \'' + data.id + '\')"></i>' +
                        '</span>' +
                        '<span class="action-icons" title="Edit'+ data.first_name +' member">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'' + plural(feature) + '\',\'edit\', \'' + data.id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'' + plural(feature) + '\',\'delete\', \'' + data.id + '\')" title="Delete'+ data.id +' participant">' +
                        '<i class="fa fa- trash"></i></span>';


                } },
                { data: "first_name" },
                { data: "last_name" },
                { data: "member_number" },
                { data: "designation_id" }, 
                { data: "date_of_birth" },
                { data: "email" },
                { data: "phone" }
            ]
        });
    });
</script>