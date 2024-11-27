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
                            <?php foreach ($result as $task): ?>
                                <tr>
                                    <td><?= esc($task['task_name']) ?></td>
                                    <td>
                                        <form action="<?= site_url('/tasks/updateStatus') ?>" method="post">
                                            <input type="hidden" name="task_id" value="<?= esc($task['id']) ?>">
                                            <select name="status_label" onchange="this.form.submit()">
                                                <option value="Not Started" <?= $task['status_label'] == 'Not Started' ? 'selected' : '' ?>><?= lang('task.not_started') ?></option>
                                                <option value="In Progress" <?= $task['status_label'] == 'In Progress' ? 'selected' : '' ?>><?= lang('task.in_progress') ?></option>
                                                <option value="Completed" <?= $task['status_label'] == 'Completed' ? 'selected' : '' ?>><?= lang('task.completed') ?></option>
                                                <option value="Rejected" <?= $task['status_label'] == 'Rejected' ? 'selected' : '' ?>><?= lang('task.rejected') ?></option>                                                
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        function updateSelectBackground(selectElement) {
            var selectedValue = selectElement.val();

            // Define a value-color mapping object
            var statusColors = {
                "not_started": "#BDD8F1",
                "in_progress": "#FAD839",
                "completed": "#00A651",
                "rejected": "#EE4749"
            };

            // Reset the background color to default (optional)
            selectElement.css('background-color', '');

            // Loop through each entry in the object to apply the corresponding color
            Object.entries(statusColors).forEach(([status, color]) => {
                if (selectedValue === status) {
                    selectElement.css('background-color', color);
                }
            });
        }

        // On document ready, update the color for all .mySelect elements based on their current selected value
        $('.mySelect').each(function() {
            updateSelectBackground($(this));
        });

        // Update background color when the user changes the selected option
        $('.mySelect').change(function() {
            updateSelectBackground($(this));
        });
    });
</script>