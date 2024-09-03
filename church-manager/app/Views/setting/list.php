<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-book'></i>
            <?= lang('setting.settings'); ?>
        </div>
    </div>
</div>   

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <!-- <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('settings.settings'); ?>
                    </div> -->
                    <div class="panel-options">                            
                        <ul class="nav nav-tabs" id ="myTabs">
                            <li class = "active"><a href="#view_profile" id="view_profile_tab" data-toggle="tab"><?= lang('setting.view_profile'); ?></a></li>
                            <li><a href="#list_departments"  data-link_id="list_departments" data-feature_plural="departments" onclick="childrenAjaxLists(this)" id="list_departments_tab" data-toggle="tab"><?= lang('department.list_departments'); ?></a></li>
                            <li><a href="#list_designations"  data-link_id="list_designations" data-feature_plural="designations" onclick="childrenAjaxLists(this)" id="list_designations_tab" data-toggle="tab"><?= lang('designation.list_designations'); ?></a></li>
                            <li><a href="#list_gatheringtypes"  data-link_id="list_gatheringtypes" data-feature_plural="gatheringtypes" onclick="childrenAjaxLists(this)" id="list_gatheringtypes_tab" data-toggle="tab"><?= lang('gatheringtypes.list_gatheringtypes'); ?></a></li>
                            <li><a href="#list_roles"  data-link_id="list_roles" data-feature_plural="roles" onclick="childrenAjaxLists(this)" id="list_roles_tab" data-toggle="tab"><?= lang('roles.list_roles'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div> 

        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="view_profile">
                    <div class = 'info'>There are no hierarchies available</div>
                </div>

                <div class="tab-pane" id="list_departments">
                    <div class = 'info'>There are no hierarchies available</div>
                </div>

                <div class="tab-pane" id="list_designations">
                    <div class = 'info'>There are no hierarchies available</div>
                </div>

                <div class="tab-pane" id="list_gatheringtypes">
                    <div class = 'info'>There are no hierarchies available</div>
                </div>

                <div class="tab-pane" id="list_roles">
                    <div class = 'info'>There are no hierarchies available</div>
                </div>
            </div>
        </div>
    </div>
</div>
