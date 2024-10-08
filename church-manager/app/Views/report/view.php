<?php 
// echo json_encode($result);
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("reports"); ?>" class="btn btn-info">Back</a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ){?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>"><?=lang('report.edit_again_button'); ?></a>
        </div>
    <?php }?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('report.view_report'); ?>
                    </div>
                    <div class="panel-options">
							
							<ul class="nav nav-tabs" id ="myTabs">
								<li class="active"><a href="#view_report" id="view_report_tab" data-toggle="tab"><?= lang('report.view_report'); ?></a></li>
								<li><a href="#view_section_a" data-item_id = "<?=$id;?>" data-link_id="view_section_a" onclick="childrenAjaxLists(this)" id="view_section_a_tab" data-toggle="tab"><?= lang('report.section_A'); ?></a></li>
                                <li><a href="#view_section_a" data-item_id = "<?=$id;?>" data-link_id="view_section_b" onclick="childrenAjaxLists(this)" id="view_section_b_tab" data-toggle="tab"><?= lang('report.section_B'); ?></a></li>
                                <li><a href="#view_section_c" data-item_id = "<?=$id;?>" data-link_id="view_section_c" onclick="childrenAjaxLists(this)" id="view_section_c_tab" data-toggle="tab"><?= lang('report.section_C'); ?></a></li>
                                <li><a href="#view_section_d" data-item_id = "<?=$id;?>" data-link_id="view_section_d" onclick="childrenAjaxLists(this)" id="view_section_d_tab" data-toggle="tab"><?= lang('report.section_D'); ?></a></li>
                            </ul>
					</div>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="tab-content">
                    <div class="tab-pane active" id="view_report">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach($result as $report => $field_value){ ?>
                                <div class = "form-group">
                                    <label for="" class = "control-label col-xs-4"><?=humanize($report);?></label>
                                    <div class = "col-xs-6">
                                        <div class = "form_view_field"><?=ucwords($field_value);?></div>
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

                    <div class="tab-pane" id="view_section_a">
                        <div class = 'info'><?= lang('report.section_A') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_b">
                        <div class = 'info'><?= lang('report.section_B') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_s">
                        <div class = 'info'><?= lang('report.section_C') ?></div>
                    </div>

                    <div class="tab-pane" id="view_section_d">
                        <div class = 'info'><?= lang('report.section_D') ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

