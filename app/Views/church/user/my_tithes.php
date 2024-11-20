<div class="tab-pane show" id="pending_tasks" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-tasks'></i>
                        <?= lang('profile.pending_tasks') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="panel-body">
                <form class="form-horizontal form-groups-bordered">
                    <div class="form-group">
                        <label for="name" class="control-label col-xs-4"><?= lang('task.add_task') ?></label>
                        <div class="col-xs-4">
                            <input class="form-control" id=myInput type="text" placeholder="Title...">
                        </div>
                        <div class="col-xs-2">
                            <div onclick="newElement()" id="btn_add_feature" class="btn btn-success"><?= lang('task.add_button') ?></div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xs-12 center heading">
                        <?= lang('task.pending_tasks_heading') ?>
                    </div>
                </div>

                <form class="form-horizontal form-groups-bordered">
                    <table id="permission_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th><?= lang('task.task_name') ?></th>
                                <th><?= lang('task.task_status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>


