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
