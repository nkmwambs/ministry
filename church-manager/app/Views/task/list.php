<style>
    .center, .heading{
        text-align: center;
        padding-bottom: 20px;
    }

    .heading {
        padding-top: 20px;
        font-weight: bold;
    }
</style>


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
                            <input class="form-control" id="my_input" name="name" type="text" placeholder="New Task Name...">
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
                                    <td><?= humanize($task['name']); ?></td>
                                    <td>
                                        <select class="form-control task_status_labels mySelect" id="task_<?= $task['id']; ?>">
                                            <option value="<?= $task['status']; ?>"><?= $task['status']; ?></option> 
                                            <option value="Not Started" <?= $task['status'] == 'Not Started' ? 'selected' : ''; ?>>Not Started</option>
                                            <option value="In Progress" <?= $task['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Completed" <?= $task['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="Rejected" <?= $task['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
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
                "Not Started": "#BDD8F1",
                "In Progress": "#FAD839",
                "Completed": "#00A651",
                "Rejected": "#EE4749"
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

    $(document).on('change', '.task_status_labels', function() {
        const status_label = $(this).val();
        const row_index = $(this).closest('tr').index();
        const user_id = $(this).attr('id');
        const url = "<?= site_url("users/profile/pending_tasks/update_task_status"); ?>";

        $.ajax({
            url: url,
            type: "POST",
            data: {status_label, user_id},
            beforeSend: function() {
                $('#overlay').css("display", "block");
            },
            success: function(response) {
                $('#overlay').css('display', 'block');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })

    // Add new task via AJAX
    $('#btn_add_feature').on('click',function() {
        var taskName = $('#my_input').val();
        
        if (taskName) {
            $.ajax({
                url: "<?=site_url('users/profile/save_task');?>", // Adjust the URL based on your routes
                type: 'POST',
                // contentType: 'application/json',
                data: {
                    taskName: taskName,
                    user_id: '<?=$parent_id;?>'
                },
                success: function(data) {
                    // if (data.success) {
                     
                        $("#profile_data").html(data)
                        // Dynamically add task to the table
                        // var newRow = `
                        // <tr data-task-id="${data.task_id}">
                        //     <td>
                        //         <span class='action-icons' title="Edit Task">
                        //             <i style="cursor:pointer" class='fa fa-pencil'></i>
                        //         </span>
                        //         <span class='action-icons' title='Delete Task'><i class='fa fa-trash'></i></span>
                        //     </td>
                        //     <td>${taskName}</td>
                        //     <td>
                        //         <select class="form-control task_status_labels mySelect">
                        //             <option value="not_started" selected>Not Started</option>
                        //             <option value="in_progress">In Progress</option>
                        //             <option value="completed">Completed</option>
                        //             <option value="rejected">Rejected</option>
                        //         </select>
                        //     </td>
                        // </tr>`;
                        // $('#permission_table tbody').append(newRow);
                        // $('#my_input').val(''); // Clear the input field
                    // }
                }
            });
        }
    });

    // Handle task status change via AJAX
    // $(document).on('change', '.mySelect', function() {
    //     var row = $(this).closest('tr');
    //     var taskId = row.data('task-id');
    //     var newStatus = $(this).val();

    //     // Send AJAX request to update task status
    //     $.ajax({
    //         url: 'pending_tasks/update_task_status', // Adjust the URL based on your routes
    //         type: 'POST',
    //         data: {
    //             task_id: taskId,
    //             status: newStatus
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 alert('Task status updated successfully');
    //             } else {
    //                 alert('Failed to update task status: ' + response.message);
    //             }
    //         },
    //         error: function() {
    //             alert('An error occurred while updating the task status');
    //         }
    //     });
    // });
</script>
