<?php 
// echo json_encode($result);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('task.edit_task') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <form id="frm_edit_role" method="post" role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" id = "task_id" value="<?=$id;?>" />

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('task.task_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" value="<?=$result['name'];?>"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="status">
                            <?= lang('task.task_status') ?>
                        </label>
                        <div class="col-xs-6">
                            
                            <select <?=$result['status'] == 'Not Started' ? 'readonly' : '';?> class="form-control" name="status" id="status">
                                <option value="Not Started" <?=$result['status'] == 'Not Started' ? 'selected': '';?>><?= lang('task.not_started') ?></option>
                                <option value="In Progress" <?=$result['status'] == 'In Progress' ? 'selected': '';?>><?= lang('task.in_progress') ?></option>
                                <option value="Completed" <?=$result['status'] == 'Completed' ? 'selected': '';?>><?= lang('task.completed') ?></option>
                                <option value="Rejected" <?=$result['status'] == 'Rejected' ? 'selected': '';?>><?= lang('task.rejected') ?></option>
                            </select>
                        </div>
                    </div>
                </form> 
            </div>

        </div>

    </div>
</div>