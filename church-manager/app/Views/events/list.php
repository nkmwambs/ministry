<div class="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('minister.list_ministers'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
      <a href="<?= site_url("ministers/add"); ?>" class='btn btn-primary'>
        <?= lang('minister.add_minister'); ?>
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th><?= lang('minister.minister_action'); ?></th>
            <th><?= lang('minister.minister_name'); ?></th>
            <th><?= lang('minister.minister_number'); ?></th>
            <th><?= lang('minister.minister_assembly_id'); ?></th>
            <th><?= lang('minister.minister_designation_id'); ?></th>
            <th><?= lang('minister.minister_phone'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $minister){?>

            <tr>
              <td>
                <span class='action-icons'><a href="<?= site_url("ministers/view/".hash_id($minister['id'])); ?>"><i
                      class='fa fa-search'></i></a></i></span>
                <span class='action-icons'><a href="<?= site_url("ministers/edit/".hash_id($minister['id'])); ?>"><i
                      class='fa fa-pencil'></i></a></span>
                <span class='action-icons'><i class='fa fa-trash'></i></span>
              </td>

              <td><?=$minister['name'];?></td>
              <td><?=$minister['minister_number'];?></td>
              <td><?=$minister['assembly_id'];?></td>
              <td><?=$minister['designation_id'];?></td>
              <td><?=$minister['phone'];?></td>

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>