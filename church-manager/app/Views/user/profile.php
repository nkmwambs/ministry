<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="col-md-3 col-xl-3">

                <div class="card">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <div class="dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <div class="page-title mb-0"><i class="fa fa-user"></i>
                            <?= lang('profile.profile_settings') ?>
                        </div>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
                            <?= lang('profile.account') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#password" role="tab">
                            <?= lang('profile.password') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.privacy_and_safety') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.email_notifications') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.web_notifications') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.widgets') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.your_data') ?>
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#" role="tab">
                            <?= lang('profile.delete_account') ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="tab-content">
                    <div class="tab-pane show" id="account" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="page-title">
                                            <i class='fa fa-globe'></i>
                                            <?= lang('user.public_info') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="panel-body">
                                    <form role="form" id="frm_add_user" method="post" class="form-horizontal form-groups-bordered">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label col-xs-4" for="inputUsername">Username</label>
                                                    <div class="col-xs-6">
                                                        <input type="text" class="form-control" id="inputUsername" placeholder="Username">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-xs-4" for="inputUsername">Biography</label>
                                                    <div class="col-xs-6">
                                                        <textarea rows="2" class="form-control" id="inputBio" placeholder="Tell something about yourself"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <img alt="Andrew Jones" src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                                    <div class="mt-2">
                                                        <span class="btn btn-primary"><i class="fa fa-upload"></i></span>
                                                    </div>
                                                    <small>For best results, use an image at least 128px by 128px in .jpg format</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="page-title">
                                            <i class='fa fa-eye-slash'></i>
                                            <?= lang('user.private_info') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel-body">
                                    <form role="form" id="frm_add_user" method="post" class="form-horizontal form-groups-bordered">
                                        <div class="form-group">
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputFirstName">First name</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputFirstName" placeholder="First name">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputLastName">Last name</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputLastName" placeholder="Last name">
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                            <!-- <div class="form-group"> -->
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputEmail4">Email</label>
                                                <div class="col-xs-6">
                                                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputAddress">Address</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputAddress2">Address 2</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                            <!-- <div class="form-group"> -->
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputCity">City</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputCity">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputState">State</label>
                                                <div class="col-xs-6">
                                                    <select id="inputState" class="form-control">
                                                        <option selected="">Choose...</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label col-xs-4" for="inputZip">Zip</label>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="inputZip">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane show" id="password" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <div class="page-title">
                                            <i class='fa fa-key'></i>
                                            <?= lang('user.password') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel-body">
                                    <h5 class="card-title">Password</h5>

                                    <form class="form-horizontal form-groups-bordered">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="control-label col-xs-4" for="inputPasswordCurrent">Current password</label>
                                                <div class="col-xs-6">
                                                    <input type="password" class="form-control" id="inputPasswordCurrent">
                                                    <small><a href="#">Forgot your password?</a></small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-4" for="inputPasswordNew">New password</label>
                                                <div class="col-xs-6">
                                                    <input type="password" class="form-control" id="inputPasswordNew">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-4" for="inputPasswordNew2">Verify password</label>
                                                <div class="col-xs-6">
                                                    <input type="password" class="form-control" id="inputPasswordNew2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>