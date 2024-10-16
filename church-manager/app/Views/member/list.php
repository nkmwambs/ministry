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
      <table class="table table-striped " id="member_dataTable">
        <thead>
          <tr>
            <?php 
              foreach($result as $column){
              ?>
                  <th><?= lang($column) ?></th> 
              <?php
              }
            ?>
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>
    </div>
  </div>

<script>
    $(document).ready(function(){
        $('#member_dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('assemblies/fetchMembers/'. $parent_id);?>',
                type: 'POST'
            },
            columns:[
                { data:null, render: function(data, type, row){
                    return '<span class="action-icons">' +
                        '<a href="<?= site_url("members/view/") ?>' + row.hash_id + '"><i class="fa fa-search"></i></a>' +
                        '</span>' +
                        '<span class="action-icons">' +
                        '<i style="cursor:pointer" onclick="showAjaxModal(\'<?= plural($feature); ?>\', \'edit\', \'' + row.hash_id + '\')" class="fa fa-pencil"></i>' +
                        '</span>' +
                        '<span class="action-icons" onclick="deleteItem(\'<?= plural($feature); ?>\', \'delete\', \'' + row.hash_id + '\')" title="Delete ' + row.hash_id + ' participant"><i class="fa fa-trash"></i></span>';
                }},
                { data: 'first_name'},
                { data: 'last_name'},
                { data: 'gender' },
                { data:'member_number'},
                { data: 'designation_name' },
                { data: 'assembly_name'},
                { data: 'date_of_birth'},
                { data: 'phone'},
            ],
        },
        )
    })

</script>