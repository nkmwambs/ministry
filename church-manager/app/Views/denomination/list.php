<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

  <div class="row">
    <div class="col-xs-12">
      <div class="page-title"><i class='fa fa-book'></i>
        <?= lang('denomination.list_denominations'); ?>
      </div>
    </div>
  </div>

  <?php 
    if(!session()->get('user_denomination_id')){
  ?>
  <div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?=plural($feature);?>','add')">   
          <?= lang('denomination.add_denomination'); ?>
        </div>
    </div>
  </div>
<?php 
    }
?>

  <div class = 'row list-alert-container hidden'>
    <div class = 'col-xs-12 info'>

    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-striped " id ="dataTable">
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
              <!-- <td>
                <span class='action-icons'>
                  <a href="<?= site_url("denominations/view/".hash_id($denomination['id'])); ?>"><i class='fa fa-search'></i></a></i>
                </span>
                <span class='action-icons'>
                  <i style="cursor:pointer" onclick="showAjaxModal('<?=plural($feature);?>','edit', '<?=hash_id($denomination['id']);?>')" class='fa fa-pencil'></i>
                </span>
                <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($denomination['id']); ?>')" title="Delete <?= $denomination['id']; ?> participant"><i class='fa fa-trash'></i></span>
              </td> -->

              <!-- <td><?=$denomination['name'];?></td>
              <td><?=$denomination['code'];?></td>
              <td><?=$denomination['registration_date'];?></td>
              <td><?=$denomination['email'];?></td>
              <td><?=$denomination['phone'];?></td>
              <td><?=$denomination['head_office'];?></td> -->

          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


  <script>
    $(document).ready(function (){
      $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "<?php echo site_url('denominations/fetchDenominations')?>",
          "type": "POST"
        },
        "columns": [
         
          {data: null, "render": function(data, type, row){

            return '<span class="action-icons">\
            <a href="' + "<?= site_url("denominations/view/".hash_id($denomination['id']));?>" + row.id + '"><i class="fa fa-search"></i></a>\
            </span>\
            <span class="action-icons">\
            <i style="cursor:pointer" onclick="showAjaxModal(\'<?=plural($feature);?>\',\'edit\', \'' + row.id + '\')" class="fa fa-pencil"></i>\
            </span>\
            <span class="action-icons" onclick="deleteItem(\'<?= plural($feature);?>\',\'delete\', \'' + row.id + '\')" title="Delete'+ row.id +'participant"><i class="fa fa-trash"></i></span>';

          }},
          {data: "name" },
          {data: "code" },
          {data: "registration_date" },
          {data: "email" },
          {data: "phone" },
          {data: "head_office" }
        ]
      })
    })
  </script>