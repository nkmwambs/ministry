
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('denomination.list_denominations'); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?=plural($feature);?>','add')">
            <?= lang('denomination.add_denomination'); ?>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped datatable">
        <thead>
          <tr>
            <th><?= lang('denomination.denomination_action') ?></th>
            <th><?= lang('denomination.denomination_name') ?></th>
            <th><?= lang('denomination.denomination_code') ?></th>
            <th><?= lang('denomination.denomination_registration_date') ?></th>
            <th><?= lang('denomination.denomination_email') ?></th>
            <th><?= lang('denomination.denomination_phone') ?></th>
            <th><?= lang('denomination.denomination_head_office') ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($result as $denomination){?>
            <tr>
              <td>
                <span class='action-icons'>
                  <a href="<?= site_url("denominations/view/".hash_id($denomination['id'])); ?>"><i class='fa fa-search'></i></a></i>
                </span>
                <span class='action-icons'>
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($denomination['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons'>
                  <i class='fa fa-trash'></i>
                </span>
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
