<div class="row">
    <div class="col-xs-12 btn-container">
        <div class='btn btn-primary' onclick="showAjaxModal('<?= plural($feature); ?>','add','<?=$parent_id != null ? $parent_id: '';?>')">
            <?=lang("$feature.add_$feature");?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($feature,'delete')">
            <i class="fa fa-trash-o"></i>
            <?= lang(singular($feature).".delete_$feature"); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($feature,'edit')">
            <i class="fa fa-pencil-square-o"></i>
            <?= lang(singular($feature).".edit_$feature"); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($feature,'view')">
            <i class="fa fa-eye"></i>
            <?= lang(singular($feature).".view_$feature"); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($feature,'print')">
            <i class="fa fa-print"></i>
            <?= lang(singular($feature).".print_$feature"); ?>
        </div>

        <div class='btn btn-primary hidden mass_action' onclick="bulkAction($feature,'export')">
            <i class="fa fa-download"></i>
            <?= lang(singular($feature).".export_$feature"); ?>
        </div>
        
    </div>
</div>