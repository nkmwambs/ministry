<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-plus-circle'></i> Add Assembly</div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_assembly" method="post" action="<?=site_url("assemblies/save")?>"
                    class="form-horizontal form-groups-bordered">

                    <?php if (session()->get('errors')): ?>
                    <div class="form-group">
                        <div class="col-xs-12 error">
                            <ul>
                                <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">Name</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="planted_at">Planted At</label>
                        <div class="col-xs-6">
                            <!-- onkeydown="return false;" -->
                            <input type="text" class="form-control datepicker" name="planted_at" id="planted_at"
                                placeholder="Enter Planted Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="location">Location</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="location" id="location"
                                placeholder="Enter Location">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="assembly_leader">Assembly Leader</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="assembly_leader"  id="assembly_leader"
                                placeholder="Edit Assembly Leader">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="entity_id">Entity_ID</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="entity_id" id="entity_id"
                                placeholder="Enter  Entity ID">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="is_active">Active</label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="is_active" id="is_active"
                                placeholder="Enter Active?">
                        </div>
                    </div>


                </form>

            </div>

        </div>

    </div>
</div>