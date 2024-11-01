<div class="tab-pane show" id="account-notifications">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-tasks'></i>
                        <?= lang('user.activity') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pb-2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input">
                            <span class="switcher-indicator">
                                <span class="switcher-yes"></span>
                                <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Email me when I pay for an event</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input">
                            <span class="switcher-indicator">
                                <span class="switcher-yes"></span>
                                <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Email me when I am assigned a role</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input">
                            <span class="switcher-indicator">
                                <span class="switcher-yes"></span>
                                <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Email me when someone views my information</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="switcher">
                            <input type="checkbox" class="switcher-input">
                            <span class="switcher-indicator">
                                <span class="switcher-yes"></span>
                                <span class="switcher-no"></span>
                            </span>
                            <span class="switcher-label">Email me when someone edits my information</span>
                        </label>
                    </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus'></i>
                        <?= lang('user.application') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pb-2">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="switcher">
                                <input type="checkbox" class="switcher-input">
                                <span class="switcher-indicator">
                                    <span class="switcher-yes"></span>
                                    <span class="switcher-no"></span>
                                </span>
                                <span class="switcher-label">News and announcements</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="switcher">
                                <input type="checkbox" class="switcher-input">
                                <span class="switcher-indicator">
                                    <span class="switcher-yes"></span>
                                    <span class="switcher-no"></span>
                                </span>
                                <span class="switcher-label">Weekly product updates</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="switcher">
                                <input type="checkbox" class="switcher-input">
                                <span class="switcher-indicator">
                                    <span class="switcher-yes"></span>
                                    <span class="switcher-no"></span>
                                </span>
                                <span class="switcher-label">Weekly blog digest</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>