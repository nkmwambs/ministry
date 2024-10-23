 
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-users'></i>
        <?= lang('user.list_users'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('users','add', '<?= $id; ?>')">
        <?= lang('user.add_user'); ?>
      </div>
    </div>
  </div>

  <div class='row list-alert-container hidden'>
    <div class='col-xs-12 info'>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped" id="dataTable">
        <thead>
          <tr>
            <th><?= lang('user.user_action') ?></th>
            <th><?= lang('user.user_first_name') ?></th>
            <th><?= lang('user.user_last_name') ?></th>
            <th><?= lang('user.user_phone') ?></th>
            <th><?= lang('user.user_email') ?></th>
            <th><?= lang('user.user_is_active') ?></th>
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
            "url": "<?php echo site_url('users/fetchUsers')?>",
            "type": "POST"
        },
        "columns": [
            {
                data: null,
                render: function(data, type, row) {
                    return '<span class="action-icons">' +
                        '<a href="<?= site_url("users/view/") ?>' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' user"><i class="fa fa-trash"></i></span>';
                }
            },
            { data: "first_name" },
            { data: "last_name" },
            { data: "phone" },
            { data: "email"},
            { data: "is_active"}
        ]
    });
});
</script>