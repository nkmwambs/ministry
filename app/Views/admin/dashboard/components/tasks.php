<script type="text/javascript">
    // Code used to add Todo Tasks
    jQuery(document).ready(function ($) {
        var $todo_tasks = $("#todo_tasks");

        $todo_tasks.find('input[type="text"]').on('keydown', function (ev) {
            if (ev.keyCode == 13) {
                ev.preventDefault();

                if ($.trim($(this).val()).length) {
                    var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>' + $(this).val() + '</label></div></li>');
                    $(this).val('');

                    $todo_entry.appendTo($todo_tasks.find('.todo-list'));
                    $todo_entry.hide().slideDown('fast');
                    replaceCheckboxes();
                }
            }
        });
    });
</script>

<div class="tile-block" id="todo_tasks">

    <div class="tile-header">
        <i class="entypo-list"></i>

        <a href="#">
            Tasks
            <span>To do list, tick one.</span>
        </a>
    </div>

    <div class="tile-content">

        <input type="text" id="add_task" class="form-control" placeholder="Add Task" />


        <ul class="todo-list">
            <li>
                <div class="checkbox checkbox-replace color-white">
                    <input id="task-1" type="checkbox" />
                    <label for="task-1">Website Design</label>
                </div>
            </li>

            <li>
                <div class="checkbox checkbox-replace color-white">
                    <input type="checkbox" id="task-2" checked />
                    <label for="task-2">Slicing</label>
                </div>
            </li>

            <li>
                <div class="checkbox checkbox-replace color-white">
                    <input type="checkbox" id="task-3" />
                    <label for="task-3">WordPress Integration</label>
                </div>
            </li>

            <li>
                <div class="checkbox checkbox-replace color-white">
                    <input type="checkbox" id="task-4" />
                    <label for="task-4">SEO Optimize</label>
                </div>
            </li>

            <li>
                <div class="checkbox checkbox-replace color-white">
                    <input type="checkbox" id="task-5" checked="" />
                    <label for="task-5">Minify &amp; Compress</label>
                </div>
            </li>
        </ul>

    </div>

    <div class="tile-footer">
        <a href="#">View all tasks</a>
    </div>

</div>