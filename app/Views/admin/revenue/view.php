<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('revenue.view_revenue'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form  class="form-horizontal form-groups-bordered">
                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('revenue.revenue_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('denomination.denomination_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['denomination_name'];?>
                        </div>
                    </div>

                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('revenue.revenue_description') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['description'];?>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

