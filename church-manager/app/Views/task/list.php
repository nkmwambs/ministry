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

                <form class="form-horizontal form-groups-bordered">
                    <table id="permission_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Task Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($tasks as $task): ?>
                                <tr data-task-id="<?= $task['id']; ?>">
                                    <td><?= $task['name']; ?></td>
                                    <td>
                                        <select class="form-control task_status_labels" id="task_<?= $task['id']; ?>">
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

    $('#btn_add_feature').click(function() {
        var taskName = $('#my_input').val();
        if (taskName) {
            // AJAX request to save task in the database
            $.ajax({
                url: 'pending_tasks/save_task',
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
                            <span class='action-icons' title="Edit task">
                                <i style="cursor:pointer" class='fa fa-pencil'></i>
                            </span>
                            <span class='action-icons' title="Delete task">
                                <i class='fa fa-trash'></i>
                            </span>
                        </td>
                        <td>${taskName}</td>
                        <td>
                            <select class="form-control permission_labels mySelect">
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

    // Handle the task status change
    $('#permission_table').on('change', '.mySelect', function() {
        var row = $(this).closest('tr'); // Get the closest table row
        var taskId = row.data('task-id'); // Assuming each row has a data-task-id attribute
        var newStatus = $(this).val(); // Get the selected status value

        // Send an AJAX request to update the task status
        $.ajax({
            url: 'pending_tasks/update_task_status', // URL to handle task status update
            type: 'POST',
            data: {
                task_id: taskId, // Task ID
                status: newStatus // New status
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

<!-- <script>
    $(document).ready(function() {
        // Function to update background color based on task status
        function updateSelectBackground(selectElement) {
            var selectedValue = selectElement.val();
            var statusColors = {
                "not_started": "#BDD8F1",
                "in_progress": "#FAD839",
                "completed": "#00A651",
                "rejected": "#EE4749"
            };

            selectElement.css('background-color', statusColors[selectedValue]);
        }

        // Event listener for adding a new task
        $('#btn_add_task').click(function() {
            var taskName = $('#task_name').val();
            if (taskName) {
                // Send AJAX request to save task to database
                $.ajax({
                    url: 'tasks/save_task', // Update this URL as per your route
                    type: 'POST',
                    data: {
                        name: taskName
                    },
                    success: function(response) {
                        if (response.success) {
                            var newTaskId = response.task_id; // Get task ID from response
                            var taskRow = `
                            <tr data-task-id="${newTaskId}">
                                <td>${taskName}</td>
                                <td>
                                    <select class="form-control task_status" id="${newTaskId}">
                                        <option value="not_started" selected>Not Started</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </td>
                            </tr>`;
                            $('#task_table tbody').append(taskRow);
                            $('#task_name').val(''); // Clear input
                        } else {
                            alert('Failed to add task');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        // Event listener for changing task status
        $('#task_table').on('change', '.task_status', function() {
            var selectElement = $(this);
            var newStatus = selectElement.val();
            var taskId = selectElement.attr('id');

            // Update the background color based on the selected status
            updateSelectBackground(selectElement);

            // Send AJAX request to update task status in the database
            $.ajax({
                url: 'tasks/update_task_status', // Update this URL as per your route
                type: 'POST',
                data: {
                    task_id: taskId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        alert('Task status updated');
                    } else {
                        alert('Failed to update status');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Apply the background color for status when the page is loaded
        $('#task_table').on('DOMNodeInserted', '.task_status', function() {
            updateSelectBackground($(this));
        });
    });
</script> -->