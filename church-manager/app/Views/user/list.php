  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-users'></i>
        <?= lang('user.list_users'); ?>
      </div>
    </div>
  </div>

  <!-- <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('users','add', '<?= $id; ?>')">
        <?= lang('user.add_user'); ?>
      </div>
    </div>
  </div> -->

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
            <tr>
              <td>
                <span class='action-icons'><a href="<?= site_url("users/view/"); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons'><a href="<?= site_url("users/edit/"); ?>"><i
                      class='fa fa-pencil'></i></a></span>
                <span class='action-icons'><i class='fa fa-trash'></i></span>
              </td>

              <td>First Name</td>
              <td>Last Name</td>
              <td>Phone</td>
              <td>Email</td>
              <td>Active</td>
        </tbody>
      </table>
    </div>
  </div>