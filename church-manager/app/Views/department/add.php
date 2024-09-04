<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('denomination.add_denomination') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_denomination" method="post" action="<?= site_url("denominations/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('department.department_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('department.department_description') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
                        </div>
                    </div>
                    
                </form>

            </div>

        </div>

    </div>
</div>