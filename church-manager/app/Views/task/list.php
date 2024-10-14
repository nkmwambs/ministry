<style>
    .center,
    .heading {
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
                        <label for="name" class="control-label col-xs-4"><?= lang('task.add_task') ?></label>
                        <div class="col-xs-4">
                            <input class="form-control" id="my_input" name="name" type="text" placeholder="New Task Name...">
                        </div>
                        <div class="col-xs-2">
                            <div id="btn_add_feature" class="btn btn-success"><?= lang('task.add_button') ?></div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xs-12 center heading">
                        <?= lang('task.pending_tasks_heading') ?>
                    </div>
                </div>

                <!-- <form class="form-horizontal form-groups-bordered" method="post"> -->
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th><?= lang('task.task_action') ?></th>
                                    <th><?= lang('task.task_name') ?></th>
                                    <th><?= lang('task.task_status') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo json_encode($result); ?>

                                <?php foreach ($result as $task): ?>
                                    <tr data-task-id="<?= $task['id']; ?>">
                                        <td>
                                            <span class='action-icons' title="Edit <?= $task['name']; ?> task">
                                                <i style="cursor:pointer" onclick="showAjaxModal('<?= plural($feature); ?>','edit', '<?= hash_id($task['id']); ?>')" class='fa fa-pencil'></i>
                                            </span>
                                            <span class='action-icons' onclick="deleteItem('<?= plural($feature); ?>','delete','<?= hash_id($task['id']); ?>')" title="Delete <?= $task['name']; ?> task"><i class='fa fa-trash'></i></span>
                                        </td>
                                        <td><?= humanize($task['name']); ?></td>
                                        <td>
                                            <form class="update_status_form" action="<?= site_url('/tasks/updateStatus') ?>" method="post">
                                                <input type="hidden" name="id" value="<?= esc($task['id']) ?>">
                                                <select class="form-control task_status_labels mySelect" id="task_<?= $task['id']; ?>" name="status">
                                                    <option class="myOption" value="Not Started" <?= $task['status'] == 'Not Started' ? 'selected' : ''; ?>><?= lang('task.not_started') ?></option>
                                                    <option class="myOption" value="In Progress" <?= $task['status'] == 'In Progress' ? 'selected' : ''; ?>><?= lang('task.in_progress') ?></option>
                                                    <option class="myOption" value="Completed" <?= $task['status'] == 'Completed' ? 'selected' : ''; ?>><?= lang('task.completed') ?></option>
                                                    <option class="myOption" value="Rejected" <?= $task['status'] == 'Rejected' ? 'selected' : ''; ?>><?= lang('task.rejected') ?></option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        function updateSelectBackground(optionElement) {
            var optionValue = optionElement.val();

            var statusColors = {
                "Not Started": "#BDD8F1",
                "In Progress": "#FAD839",
                "Completed": "#00A651",
                "Rejected": "#EE4749"
            };

            optionElement.css('background-color', '');

            // Loop through each entry in the object to apply the corresponding color
            Object.entries(statusColors).forEach(([status, color]) => {
                if (optionValue === status) {
                    optionElement.css('background-color', color);
                }
            });
        }

        // On document ready, update the color for all .mySelect elements based on their current selected value
        $('.myOption').each(function() {
            updateSelectBackground($(this));
        });

        // Update background color when the user changes the selected option
        $('.myOption').change(function() {
            updateSelectBackground($(this));
        });
    });

    // $(document).on('change', '.task_status_labels', function() {
    //     const status_label = $(this).val();
    //     const row_index = $(this).closest('tr').index();
    //     const user_id = $(this).attr('id');
    //     const url = "<?= site_url("/tasks/updateStatus"); ?>";

    //     $.ajax({
    //         url: url,
    //         type: "POST",
    //         data: {
    //             status_label,
    //             user_id
    //         },
    //         beforeSend: function() {
    //             $('#overlay').css("display", "block");
    //         },
    //         success: function(response) {
    //             $('#overlay').css('display', 'block');
    //         },
    //         error: function(xhr, status, error) {
    //             console.log(xhr.responseText);
    //         }
    //     })
    // })

    // Add new task via AJAX
    $('#btn_add_feature').on('click', function() {
        var taskName = $('#my_input').val();

        if (taskName) {
            $.ajax({
                url: "<?= site_url('users/profile/save_task'); ?>", // Adjust the URL based on your routes
                type: 'POST',
                data: {
                    taskName: taskName,
                    user_id: '<?= $parent_id; ?>'
                },
                success: function(data) {

                    $("#profile_data").html(data)
                }
            });
        }
    });

    $('.datatable').DataTable({
        stateSave: true,
    });

    $('.mySelect').on('change', function(ev) {
        const form = $(this).closest('form');
        const data = form.serializeArray();
        const url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data) {
                // console.log(data);
            }
        })
        ev.preventDefault();
    })
</script>