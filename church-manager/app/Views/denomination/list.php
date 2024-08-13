<div class="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('denomination.list_denominations'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <a href="<?= site_url("denominations/add"); ?>" class='btn btn-primary'>
        <?= lang('denomination.add_denomination'); ?>
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th>Action</th>
            <th>Name</th>
            <th>Code</th>
            <th>Registration Date</th>
            <th>Email</th>
            <th>Phome</th>
            <th>Head Office</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $denomination){?>
            <tr>
              <td>
                <span class='action-icons'><a href="<?= site_url("denominations/view/".hash_id($denomination['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons'><a href="<?= site_url("denominations/edit/".hash_id($denomination['id'])); ?>"><i
                      class='fa fa-pencil'></i></a></span>
                <span class='action-icons'><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$denomination['name'];?></td>
              <td><?=$denomination['code'];?></td>
              <td><?=$denomination['registration_date'];?></td>
              <td><?=$denomination['email'];?></td>
              <td><?=$denomination['phone'];?></td>
              <td><?=$denomination['head_office'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>