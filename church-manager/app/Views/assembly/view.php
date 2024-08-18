<?php 
$member_sections = array_pop($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("assemblies"); ?>" class="btn btn-info">Back</a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ){?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>">Edit Again</a>
        </div>
    <?php }?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('assembly.view_assembly'); ?>
                    </div>
                    <div class="panel-options">
							
							<ul class="nav nav-tabs" id ="myTabs">
								<li class="active"><a href="#view_assembly" id="view_assembly_tab" data-toggle="tab"><?= lang('assembly.view_assembly'); ?></a></li>
								<li><a href="#list_hierarchies" data-item_id = "<?=$id;?>" data-link_id="list_hierarchies" data-feature_plural="members" onclick="childrenAjaxLists(this)" id="list_members_tab" data-toggle="tab"><?= lang('member.list_members'); ?></a></li>
                                <?php foreach($member_sections as $member){?>
                                    <li><a href="#list_<?=plural(underscore($member['name']));?>" data-link_id="list_<?=plural(underscore($member['name']));?>" data-item_id = "<?=hash_id($member['id'],'encode');?>" data-feature_plural="entities" onclick="childrenAjaxLists(this)" id="list_<?=plural(underscore($member['name']));?>_tab" data-toggle="tab"><?=plural(ucfirst($member['name'])); ?></a></li>
                                <?php }?>
                            </ul>
					</div>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="tab-content">
                    <div class="tab-pane active" id="view_assembly">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach($result as $field_name => $field_value){ ?>
                                <div class = "form-group">
                                    <label for="" class = "control-label col-xs-4"><?=humanize($field_name);?></label>
                                    <div class = "col-xs-6">
                                        <div class = "form_view_field"><?=$field_value;?></div>
                                    </div>
                                </div>
                            <?php } ?>
            
                            <div class = "form-group">
                                <div class = "col-xs-offset-4 col-xs-6">
                                    <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>" class="btn btn-primary">Edit</a>
                                </div>
                            </div> 
                        </form>
                    </div>

                    <div class="tab-pane" id="list_members">
                        <div class = 'info'>There are no hierarchies available</div>
                    </div>

                    <?php foreach($member_sections as $member){?>
                        <div class="tab-pane" id="list_<?=plural(underscore($member['name']));?>">
                            <div class = 'info'>There are no <?=plural($member['name']);?> available</div>
                        </div>
                    <?php }?>

                </div>
            </div>

        </div>
    </div>
</div>

