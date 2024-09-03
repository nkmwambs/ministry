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
                            <li><a href="#view_departments"  data-link_id="view_departments" data-feature_plural="departments" onclick="childrenAjaxLists(this)" id="view_departments_tab" data-toggle="tab"><?= lang('setting.view_departments'); ?></a></li>
                            <li><a href="#view_designations"  data-link_id="view_designations" data-feature_plural="designations" onclick="childrenAjaxLists(this)" id="view_designations_tab" data-toggle="tab"><?= lang('setting.view_designations'); ?></a></li>
                            <li><a href="#view_gatheringtypes"  data-link_id="view_gatheringtypes" data-feature_plural="gatheringtypes" onclick="childrenAjaxLists(this)" id="view_gatheringtypes_tab" data-toggle="tab"><?= lang('setting.view_gatheringtypes'); ?></a></li>
                            <li><a href="#view_collectiontypes"  data-link_id="view_collectiontypes" data-feature_plural="collectiontypes" onclick="childrenAjaxLists(this)" id="view_collectiontypes_tab" data-toggle="tab"><?= lang('setting.view_collectiontypes'); ?></a></li>
                            <li><a href="#view_roles"  data-link_id="view_roles" data-feature_plural="roles" onclick="childrenAjaxLists(this)" id="list_roles_tab" data-toggle="tab"><?= lang('setting.view_roles'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div> 

        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active show" id="view_profile">
                    <?= include('profile.php') ?>
                </div>


                <div class="tab-pane" id="view_departments">
                    <div class = 'info'>There are no departments available</div>
                </div>

                <div class="tab-pane" id="view_designations">
                    <div class = 'info'>There are no designations available</div>
                </div>

                <div class="tab-pane" id="view_gatheringtypes">
                    <div class = 'info'>There are no gatheringtypes available</div>
                </div>

                <div class="tab-pane" id="view_collectiontypes">
                    <div class = 'info'>There are no collectiontypes available</div>
                </div>

                <div class="tab-pane" id="view_roles">
                    <div class = 'info'>There are no roles available</div>
                </div>
            </div>
        </div>
    </div>
</div>
