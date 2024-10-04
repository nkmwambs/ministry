<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('field.view_customfield'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form  class="form-horizontal form-groups-bordered">
                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_feature_id') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['feature_id'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_type') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['type'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_options') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['options'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_field_order') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['field_order'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('field.customfield_visible') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['visible'];?>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

