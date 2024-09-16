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
                <form class="form-horizontal form-groups-bordered" method="post">
                    <div class="form-group">
                        <label for="name" class="control-label col-xs-4">Add a Task</label>
                        <div class="col-xs-4">
                            <input class="form-control" id=my_input type="text" placeholder="New Task Name...">
                        </div>
                        <div class="col-xs-2">
                            <div id="btn_add_feature" class="btn btn-success">Add</div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xs-12 center heading">
                        Pending Tasks
                    </div>
                </div>

                <form class="form-horizontal form-groups-bordered" method="post">
                    <table id="permission_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Task Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($result as $task): ?>
                                <tr data-task-id="<?= $task['id']; ?>">
                                    <td>
                                        <span class='action-icons' title="Edit Task">
                                            <i style="cursor:pointer" class='fa fa-pencil'></i>
                                        </span>
                                        <span class='action-icons' title='Delete Task'><i class='fa fa-trash'></i></span>
                                    </td>
                                    <td><?= $task['name']; ?></td>
                                    <td>
                                        <select class="form-control task_status_labels" id="task_<?= $task['id']; ?>">
                                            <option value="<?= $task['status']; ?>"><?= $task['status']; ?></option> 
                                            <option value="not_started" <?= $task['status'] == 'not_started' ? 'selected' : ''; ?>>Not Started</option>
                                            <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="rejected" <?= $task['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- <tr>
                                <td>
                                    <span class='action-icons' title="Edit task">
                                        <i style="cursor:pointer" class='fa fa-pencil'></i>
                                    </span>
                                    <span class='action-icons' title="Delete task"><i class='fa fa-trash'></i></span>
                                </td>
                                <td>
                                    Charity
                                </td>
                                <td>
                                    <select class="form-control permission_labels mySelect" id="">
                                        <option value="not_started">Not Started</option>
                                        <option value="in_progress" selected>In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </td>
                            </tr> -->

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

            var statusColors = {
                "not_started": "#BDD8F1",
                "in_progress": "#FAD839",
                "completed": "#00A651",
                "rejected": "#EE4749"
            };

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

    // Add new task via AJAX
    $(document).on('click', '#btn_add_feature', function() {
        var taskName = $('#my_input').val();
        
        if (taskName) {
            $.ajax({
                url: 'pending_tasks/save_task', // Adjust the URL based on your routes
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    name: taskName
                }),
                success: function(data) {
                    if (data.success) {
                        // Dynamically add task to the table
                        var newRow = `
                        <tr data-task-id="${data.task_id}">
                            <td>
                                <span class='action-icons' title="Edit Task">
                                    <i style="cursor:pointer" class='fa fa-pencil'></i>
                                </span>
                                <span class='action-icons' title='Delete Task'><i class='fa fa-trash'></i></span>
                            </td>
                            <td>${taskName}</td>
                            <td>
                                <select class="form-control task_status_labels mySelect">
                                    <option value="not_started" selected>Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </td>
                        </tr>`;
                        $('#permission_table tbody').append(newRow);
                        $('#my_input').val(''); // Clear the input field
                    }
                }
            });
        }
    });

    // Handle task status change via AJAX
    $('#permission_table').on('change', '.mySelect', function() {
        var row = $(this).closest('tr');
        var taskId = row.data('task-id');
        var newStatus = $(this).val();

        // Send AJAX request to update task status
        $.ajax({
            url: 'pending_tasks/update_task_status', // Adjust the URL based on your routes
            type: 'POST',
            data: {
                task_id: taskId,
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    alert('Task status updated successfully');
                } else {
                    alert('Failed to update task status: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while updating the task status');
            }
        });
    });
</script>
