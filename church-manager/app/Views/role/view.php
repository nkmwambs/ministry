<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('role.view_role'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form  class="form-horizontal form-groups-bordered">
                    <div class = "form-group">
                        <div class="col-xs-4">
                            <label><?= lang('role.role_name') ?></label>
                        </div>
                        <div class = "col-xs-8">
                            <?=$result['name'];?>
                        </div>
                    </div>

                    <!-- <?php foreach($result as $field_name => $field_value) { ?> -->
                        <div class = "form-group">
                            <div class="col-xs-4">
                                <label><?= lang('role.feature_name'); ?></label>
                                <!-- <label><?= humanize($field_name); ?></label> -->
                            </div>
                            <div class = "col-xs-8">
                                <!-- <?=$result['name'];?> -->
                                <select class="form-control" name="feature_id" id="feature_id">
                                    <option value="">Select a Permission</option>
                                    <?php foreach($features as $feature) { ?>
                                        <option value="<?php echo $feature['id']; ?>"><?php echo $feature['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <!-- <?php } ?> -->

                </form>
            </div>

        </div>
    </div>
</div>

