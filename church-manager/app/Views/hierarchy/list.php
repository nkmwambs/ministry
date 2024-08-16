  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('hierarchy.list_hierarchies'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <div class='btn btn-primary' onclick="showAjaxModal('hierarchies','add', '<?=$id;?>')">
            <?= lang('hierarchy.add_hierarchy'); ?>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th>Action</th>
            <th>Name</th>
            <th>level</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $hierarchy){?>
            <tr>
              <td>
                <span class='action-icons'><a href="<?= site_url("hierarchies/view/".hash_id($hierarchy['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons'><a href="<?= site_url("hierarchies/edit/".hash_id($hierarchy['id'])); ?>"><i
                      class='fa fa-pencil'></i></a></span>
                <span class='action-icons'><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$hierarchy['name'];?></td>
              <td><?=$hierarchy['level'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
