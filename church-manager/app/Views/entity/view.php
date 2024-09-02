<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('entity.view_entity'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form  class="form-horizontal form-groups-bordered">
                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label>Entity Name</label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label>Entity Number</label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['entity_number'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label>Hierarchy Name</label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['hierarchy_name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label>Parent Entity</label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['parent_name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label>Entity Leader</label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['entity_leader'];?>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

