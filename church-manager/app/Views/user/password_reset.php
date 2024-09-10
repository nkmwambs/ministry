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
