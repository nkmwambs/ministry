<div class="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-users'></i>
        <?= lang('user.list_users'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <a href="<?= site_url("users/add"); ?>" class='btn btn-primary'>
        <?= lang('user.add_user'); ?>
      </a>
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
            <th>Action</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Active Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $user){?>
            <tr>
              <td>
                <span class='action-icons'><a href="<?= site_url("users/view/".hash_id($user['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons'><a href="<?= site_url("users/edit/".hash_id($user['id'])); ?>"><i
                      class='fa fa-pencil'></i></a></span>
                <span class='action-icons'><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$user['first_name'];?></td>
              <td><?=$user['last_name'];?></td>
              <td><?=$user['phone'];?></td>
              <td><?=$user['email'];?></td>
              <td><?=$user['is_active'];?></td>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>