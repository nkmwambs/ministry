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
        <form role="form" method="post" action="<?= site_url("users/store") ?>" class="form-horizontal form-groups-bordered">

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
                    <option value="<?= $denomination['id']; ?>"><?= $denomination['name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php } else { ?>
            <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
          <?php } ?>

          <!-- User Information Fields -->
          <div class="form-group">
            <label class="control-label col-xs-4" for="first_name">First Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="last_name">Last Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="date_of_birth">Date Of Birth</label>
            <div class="col-xs-6">
              <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Date of birth">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="gender">Gender</label>
            <div class="col-xs-6">
              <select class="form-control" name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="email">Email</label>
            <div class="col-xs-6">
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="phone">Phone</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" required>
            </div>
          </div>

          <!-- Roles -->
          <div class="form-group">
            <label class="control-label col-xs-4" for="roles">Roles</label>
            <div class="col-xs-6">
              <select class="form-control js-multiple" name="roles" id="roles">
                <option value="">Select roles</option>
              </select>
            </div>
          </div>

          <!-- System Administrator -->
          <div class="form-group">
            <label class="control-label col-xs-4" for="is_system_admin">Is system Administrator</label>
            <div class="col-xs-6">
              <select class="form-control" name="is_system_admin" id="is_system_admin">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
          </div>

          <!-- Permitted Entities -->
          <!-- <div class="form-group">
            <label for="permitted_entities" class="control-label col-xs-4">Permitted Entities</label>
            <div class="col-xs-6">
              <select class="form-control js-multiple" name="permitted_entities" id="permitted_entities">
                <option value="">Select Permitted Entities</option>
              </select>
            </div>
          </div> -->

          <div class="form-group">
            <label for="permitted_entities" class="control-label col-xs-4">Permitted Entities:</label>
            <div class="col-xs-6">
              <select id="permitted_entities" name="permitted_entities[]" class="form-control select_fields" multiple>
                <option>Option 1</option>
              </select>
            </div>
          </div>


          <!-- Permitted Assemblies -->
          <div class="form-group">
            <label class="control-label col-xs-4" for="permitted_assemblies">Permitted Assemblies</label>
            <div class="col-xs-6">
              <select class="form-control" name="permitted_assemblies" id="permitted_assemblies">
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
  $(document).ready(
    function() {
      $('select.select_fields').select2()
    }
  )
</script>