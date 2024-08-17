<div class="row">
  <div class="col-xs-12 btn-container">
    <a href="<?=site_url("denominations");?>" class="btn btn-info"><?=lang('system.back')?></a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-users'></i><?=lang('user.add_user')?></div>
        </div> 

      </div>

      <div class="panel-body">

        <form role="form" method="post" action="<?=site_url("users/save")?>" class="form-horizontal form-groups-bordered">
          
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
        
          <div class="form-group">
            <label class="control-label col-xs-4" for="first_name">First Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="first_name" id="last_name"
                placeholder="Enter First Name" required>
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
              <input type="text" onkeydown="return false;" class="form-control datepicker" name="date_of_birth"
                id="date_of_birth" placeholder="Date of birth">
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

          <div class="form-group">
            <label class="control-label col-xs-4" for="roles">Roles</label>
            <div class="col-xs-6">
              <select class="form-control" name="roles" id="roles">
                <option value="">Select roles</option>
              </select>
            </div>
          </div>

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

          <div class="form-group">
            <label class="control-label col-xs-4" for="permitted_entities">Permitted Entities</label>
            <div class="col-xs-6">
              <select class="form-control" name="permitted_entities" id="permitted_entities">
                <option value="">Select entities</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-xs-4" for="permitted_assemblies">Permitted Assemblies</label>
            <div class="col-xs-6">
              <select class="form-control" name="permitted_assemblies" id="permitted_assemblies">
                <option value="">Select Assemblies</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-offset-4 col-xs-6">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="submit" class="btn btn-primary">Save and New</button>
              <button type="submit" class="btn btn-primary">Reset</button>
            </div>
          </div>
        </form>

      </div>

    </div>

  </div>
</div>