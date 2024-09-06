
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('designation.add_designation') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_designation" method="post" action="<?= site_url("designation/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('designation.designation_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="designation_id">
                            <?= lang('designation.denomination_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="denomination_id" id="denomination_id" placeholder="Enter Denomination Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="hierarchy_id">
                            <?= lang('designation.hierarchy_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="hierarchy_id" id="hierarchy_id" placeholder="Enter Hierarchy Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="department_id">
                            <?= lang('designation.department_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="department_id" id="department_id" placeholder="Enter Department Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="minister_title_designation">
                            <?= lang('designation.minister_title_designation') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="minister_title_designation" id="minister_title_designation" placeholder="Enter Minister Name ">
                        </div>
                    </div>
                    
                    
                </form>

            </div>

        </div>

    </div>
</div>
