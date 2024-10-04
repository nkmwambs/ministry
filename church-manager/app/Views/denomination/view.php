<?php 
$hierarchy_sections = array_pop($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("denominations"); ?>" class="btn btn-info">
            <?= lang('denomination.back_button') ?>
        </a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ){?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>"><?= lang('denomination.edit_again_buttton') ?></a>
        </div>
    <?php }?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('denomination.view_denomination'); ?>
                    </div>
                    <div class="panel-options">
							
							<ul class="nav nav-tabs" id ="myTabs">
								<li class = "active"><a href="#view_denomination" id="view_denomination_tab" data-toggle="tab"><?= lang('denomination.view_denomination'); ?></a></li>
								<li><a href="#list_hierarchies" data-item_id = "<?=$parent_id;?>" data-link_id="list_hierarchies" data-feature_plural="hierarchies" onclick="childrenAjaxLists(this)" id="list_hierarchies_tab" data-toggle="tab"><?= lang('hierarchy.list_hierarchies'); ?></a></li>
                                
                            </ul>
					</div>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="tab-content">
                    <div class="tab-pane active" id="view_denomination">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach($result as $department => $field_value){ ?>
                                <div class = "form-group">
                                    <label for="" class = "control-label col-xs-4"><?=humanize($department);?></label>
                                    <div class = "col-xs-6">
                                        <div class = "form_view_field"><?=$field_value;?></div>
                                    </div>
                                </div>
                            <?php } ?> 
            
                            <!-- <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div>  -->
                        </form>
                    </div>

                    <div class="tab-pane" id="list_hierarchies">
                        <div class = 'info'>There are no hierarchies available</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ajaxSuccess(function(ev) {
        createEntityTabs()
    });

    $(document).ready(function() {
    createEntityTabs()
    });

     function createEntityTabs(){
        const myTabs = $('#myTabs')
        const tab_content = $(".tab-content")
        const parent_id = "<?=$parent_id;?>"

        const url = "<?=site_url();?>hierarchies/denomination/" + parent_id

        fetch(url)
        .then(response => response.json())
        .then(hierarchies => {
            $.each(hierarchies, function (index, elem) {
                const plural_name = pluralize(elem.name).replace(/\s/g, '')
                if($('.li_'+plural_name).length == 0){
                    myTabs.append('<li data-item_id = "'+elem.id+'" data-link_id="list_'+ plural_name +'" data-feature_plural="entities" onclick="childrenAjaxLists(this)" class = "li_'+plural_name+'"><a href="#list_'+plural_name+'" id="list_'+plural_name+'_tab" data-toggle="tab">' + pluralize(elem.name) + '</a></li>')
                    tab_content.append('<div id = "list_'+plural_name+'" class = "tab-pane"><div class = "info">There are not ' + pluralize(elem.name) + ' available</div></div>')
                }
            })
     })}
    
     $("#myTabs").on('click', function(ev){
        const tabs = $(this)
        const target_tab = $(ev.target).attr('href')
        const tab_content = $('.tab-content')
        const tab_panes = tab_content.find('.tab-pane')

    // const tab_panes = tab_content.find('.tab-pane')

    $.each(tab_panes, function (index, pane){
        $(pane).removeClass('ajax_main')
    })

    $(target_tab).addClass('ajax_main')
    })
</script>