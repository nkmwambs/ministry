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
                            <input class="form-control" id=myInput type="text" placeholder="Title...">
                        </div>
                        <div class="col-xs-2">
                            <div onclick="newElement()" id="btn_add_feature" class="btn btn-success">Add</div>
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
                            <tr>
                                <td>
                                    <span class='action-icons' title="Edit task">
                                        <i style="cursor:pointer" class='fa fa-pencil'></i>
                                    </span>
                                    <span class='action-icons' title="Delete task"><i class='fa fa-trash'></i></span>
                                </td>
                                <td>
                                    Server Maintenance
                                </td>
                                <td>
                                    <select class="form-control permission_labels mySelect" id="">
                                        <option value="not_started" selected>Not Started</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
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
                            </tr>
                            <tr>
                                <td>
                                    <span class='action-icons' title="Edit task">
                                        <i style="cursor:pointer" class='fa fa-pencil'></i>
                                    </span>
                                    <span class='action-icons' title="Delete task"><i class='fa fa-trash'></i></span>
                                </td>
                                <td>
                                    App Development
                                </td>
                                <td>
                                    <select class="form-control permission_labels mySelect" id="">
                                        <option value="not_started">Not Started</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed" selected>Completed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class='action-icons' title="Edit task">
                                        <i style="cursor:pointer" class='fa fa-pencil'></i>
                                    </span>
                                    <span class='action-icons' title="Delete task"><i class='fa fa-trash'></i></span>
                                </td>
                                <td>
                                    Procurement
                                </td>
                                <td>
                                    <select class="form-control permission_labels mySelect" id="">
                                        <option value="not_started">Not Started</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="rejected" selected>Rejected</option>
                                    </select>
                                </td>
                            </tr>
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