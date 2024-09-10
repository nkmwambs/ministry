<?php
$numeric_denomination_id = hash_id($parent_id);
$numeric_hierarchy_id = hash_id("hierarchy_id");
$numeric_entity_id = hash_id($entity_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">
      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-users'></i><?= lang('user.add_user') ?></div>
        </div>
      </div>

      <div class="panel-body">
        <form role="form" id = "frm_add_user"  method="post" action="<?= site_url("users/save") ?>" class="form-horizontal form-groups-bordered">

        <div class="form-group hidden error_container">
                  <div class="col-xs-12 error">
                    
                  </div>
              </div>

          <!-- Error Display -->
          <?php if (session()->get('errors')): ?>
            <div class="form-group">
              <div class="col-xs-12 error">
                <ul>
                  <?php foreach (session()->get('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                  <?php endforeach ?>
                </ul>
              </div>
            </div>
          <?php endif ?>

          <!-- Denomination Selection -->
          <?php if (!$numeric_denomination_id) { ?>
            <div class='form-group'>
              <label for="denomination_id" class="control-label col-xs-4"><?= lang('event.event_denomination_id') ?></label>
              <div class="col-xs-6">
                <select class="form-control" name="denomination_id" id="denomination_id">
                  <option value=""><?= lang('event.select_denomination') ?></option>
                  <?php foreach ($denominations as $denomination) : ?>
                    <option value="<?= hash_id($denomination['id'],'encode'); ?>"><?= $denomination['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
          <?php } ?>

          <!-- User Information Fields -->
          <div class="form-group">
            <label class="control-label col-xs-2" for="first_name">First Name</label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" required>
            </div>
          
            <label class="control-label col-xs-2" for="last_name">Last Name</label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="date_of_birth">Date Of Birth</label>
            <div class="col-xs-3">
              <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Date of birth">
            </div>

            <label class="control-label col-xs-2" for="gender">Gender</label>
            <div class="col-xs-3">
              <select class="form-control" name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-2" for="email">Email</label>
            <div class="col-xs-3">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
            </div>
          
            <label class="control-label col-xs-2" for="phone">Phone</label>
            <div class="col-xs-3">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" required>
            </div>
          </div>

          <!-- Roles -->
          <div class="form-group">
            <label class="control-label col-xs-4" for="roles">Roles</label>
            <div class="col-xs-6">
              <select class="form-control select_fields" name="roles[]" id="roles" multiple>
                <option value="">Select roles</option>
                <?php foreach ($roles as $role) :?>
                  <option value="<?php echo $role['id'];?>"><?php echo $role['name'];?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>

          <!-- System Administrator -->
          <?php if (!$numeric_denomination_id) { ?>
          <div class="form-group">
            <label class="control-label col-xs-4" for="is_system_admin">Is system Administrator</label>
            <div class="col-xs-6">
              <select class="form-control" name="is_system_admin" id="is_system_admin">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no" selected >No</option>
              </select>
            </div>
          </div>
          <?php }?>

          <!-- Permitted Entities -->
            <div class="form-group">
              <label for="permitted_entities" class="control-label col-xs-4">User Hierachies Level</label>
              <div class="col-xs-6">
                <select class="form-control" name="" id="hierarchy_id">
                  <option value="">Select a Hierarchy Level</option>
                  <?php if($numeric_denomination_id){?>
                    <?php foreach ($hierarchies as $hierarchy) :?>
                      <option value="<?php echo $hierarchy['id'];?>"><?php echo $hierarchy['name'];?></option>
                    <?php endforeach;?>
                  <?php }?>
                </select>
              </div>
            </div>
          
          

          <div class="form-group hidden">
            <label for="permitted_entities" class="control-label col-xs-4">Permitted Entities:</label>
            <div class="col-xs-6">
              <select id="permitted_entities" name="permitted_entities[]" class="form-control select_fields" multiple>
                <?php foreach ($entities as $hierarchy_name => $hierarchy_entities): ?>
                  <optgroup label="<?= $hierarchy_name ?>">
                    <?php foreach ($hierarchy_entities as $entity): ?>
                      <option value="<?= $entity['id'] ?>"><?= $entity['name'] ?></option>
                    <?php endforeach; ?>
                  </optgroup>
                <?php endforeach; ?>
              </select>
            </div>
          </div>


          <!-- Permitted Assemblies -->
          <div class="form-group hidden">
            <label class="control-label col-xs-4" for="permitted_assemblies">Permitted Assemblies</label>
            <div class="col-xs-6">
              <select class="form-control select_fields" name="permitted_assemblies[]" id="permitted_assemblies" multiple>
                <option value="">Select Assemblies</option>
              </select>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#denomination_id').on('change', function() {
    const $denomination_id = $(this).val()
    const base_url = '<?=site_url('hierarchies/all_denomination')?>' 

    $.ajax({
      url: base_url + '/' + $denomination_id,
      type: 'GET',
      success: function(response) {
        let options = "<option value=''>Select a Hierarchy Level</option>";
        for(let i = 0; i < response.length; i++) {
          options += "<option value='" + response[i].id + "'>" + response[i].name + "</option>";
        }
        options += "<option value='0'>Assembly</option>";
        $('#hierarchy_id').html(options)
      }
    })
  })

  $('#hierarchy_id').on('change', function() {
    const $hierarchy_id = $(this).val()
    
    if($hierarchy_id == '0') {
      $('#permitted_entities').closest('.form-group').addClass('hidden')
      $('#permitted_assemblies').closest('.form-group').removeClass('hidden')
      $('#permitted_entities').val(null).trigger('change');

      const base_url = '<?=site_url('assemblies/denomination')?>' 
      const denomination_id = $('#denomination_id').val()

      $.ajax({
          url: base_url + "/" + denomination_id,
          type: 'GET',
          success: function(response) {
            let options = "<option value=''>Select Permitted Assemblies</option>";
            for(let i = 0; i < response.length; i++) {
              options += "<option value='" + response[i].id + "'>" + response[i].name + "</option>";
            }
            $('#permitted_assemblies').html(options)
          }
      })

    } else {
      $('#permitted_entities').closest('.form-group').removeClass('hidden')
      $('#permitted_assemblies').closest('.form-group').addClass('hidden')
      $('#permitted_assemblies').val(null).trigger('change');
      

      const base_url = '<?=site_url('entities/hierarchy')?>' 

      $.ajax({
          url: base_url + '/' + $hierarchy_id,
          type: 'GET',
          success: function(response) {
            let options = "<option value=''>Select Permitted Entities</option>";
            for(let i = 0; i < response.length; i++) {
              options += "<option value='" + response[i].id + "'>" + response[i].name + "</option>";
            }
            $('#permitted_entities').html(options)
          }
      })
    }

    
})
</script>