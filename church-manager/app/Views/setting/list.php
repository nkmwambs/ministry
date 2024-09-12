<?php 

$parent_id = 0;

if(session()->get('user_denomination_id')){
    $parent_id = session()->get('user_denomination_id');
}

$parent_id = hash_id($parent_id, 'encode');

?>
<div class="row">
    <div class="col-xs-12">
        <div class="page-title"><i class='fa fa-gear'></i>
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
                        <ul class="nav nav-tabs" id="myTabs">
                            <!-- <li class = "active"><a href="#view_profile" id="view_profile_tab" data-toggle="tab"><?= lang('setting.view_profile'); ?></a></li> -->
                            <li class="active"><a href="#view_departments" data-item_id="<?=$parent_id;?>" data-link_id="view_departments" data-feature_plural="departments" onclick="childrenAjaxLists(this)" id="view_departments_tab" data-toggle="tab"><?= lang('setting.view_departments'); ?></a></li>
                            <li><a href="#view_designations" data-item_id="<?=$parent_id;?>" data-link_id="view_designations" data-feature_plural="designations" onclick="childrenAjaxLists(this)" id="view_designations_tab" data-toggle="tab"><?= lang('setting.view_designations'); ?></a></li>
                            <li><a href="#view_meetings" data-item_id="<?=$parent_id;?>" data-link_id="view_meetings" data-feature_plural="meetings" onclick="childrenAjaxLists(this)" id="view_meetings_tab" data-toggle="tab"><?= lang('setting.view_meetings'); ?></a></li>
                            <li><a href="#view_revenues" data-item_id="<?=$parent_id;?>" data-link_id="view_revenues" data-feature_plural="revenues" onclick="childrenAjaxLists(this)" id="view_revenues_tab" data-toggle="tab"><?= lang('setting.view_revenues'); ?></a></li>
                            <li><a href="#view_roles" data-item_id="<?=$parent_id;?>" data-link_id="view_roles" data-feature_plural="roles" onclick="childrenAjaxLists(this)" id="list_roles_tab" data-toggle="tab"><?= lang('setting.view_roles'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane" id="view_departments">
                        <!-- <div class='info'>There are no departments available</div> -->
                    </div>

                    <div class="tab-pane" id="view_designations">
                        <!-- <div class='info'>There are no designations available</div> -->
                    </div>

                    <div class="tab-pane" id="view_meetings">
                        <!-- <div class='info'>There are no meetings available</div> -->
                    </div>

                    <div class="tab-pane" id="view_revenues">
                        <!-- <div class='info'>There are no revenues available</div> -->
                    </div>

                    <div class="tab-pane" id="view_roles">
                        <!-- <div class='info'>There are no roles available</div> -->
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<script>

    // $(document).on('click', '#view_departments_tab', function() {
    //     $('#view_departments').addClass('active')
    // });

    $(document).ready(function () {
        // document.getElementById("view_departments_tab").click();
        const elem = $('#view_departments_tab')
        childrenAjaxLists(elem)
        $('#view_departments').addClass('active')
    })
    
</script>