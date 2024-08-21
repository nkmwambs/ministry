<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i> Edit Member</div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_member" method="post" action="<?=site_url('members/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />
                    <input type="hidden" name="member_id" value="<?=hash_id($result['member_id']);?>" />

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

                    <div class="panel-body">

<form role="form" id="frm_add_member" method="post" action="<?=site_url("members/save")?>"
    class="form-horizontal form-groups-bordered">

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
            <input type="text" class="form-control" name="first_name" id="first_name"
                placeholder="Enter Name">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="last_name">Last Name</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="last_name" id="last_name"
                placeholder="Enter Name">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="member_number"> Member Number</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="member_number" id="member_number"
                placeholder="Enter Number">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="designation_id"> Designation ID</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="designation_id" id="designation_id"
                placeholder="Enter Designation ID">
        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-xs-4" for="date_of_birth"> Date of Birth</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth"
                placeholder="Enter Date of Birth">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="email"> Email</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="email" id="email"
                placeholder="Enter email">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="phone"> Phone</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="phone" id="phone"
                placeholder="Enter phone Number">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="is_active">Is Active?</label>
        <div class="col-xs-6">
            <select class="form-control" name="is_active" id="is_active">
                <option value="">Active</option>

            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="assembly_id"> Assembly ID</label>
        <div class="col-xs-6">
            <input type="text" class="form-control" name="assembly_id" id="assembly_id"
                placeholder="Enter Assembly ID">
        </div>
    </div>

</form>

</div>
                </form>
            </div>
        </div>
    </div>
</div>