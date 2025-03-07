<?php 
$visitor_sections = array_pop($result);
?>

<div class = "row">
    <?php if(session()->getFlashdata('message') ) { ?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($designation).'/edit/' . $id) ?>">
                <?= lang('member.edit_again_button') ?>
            </a>
        </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('member.view_member'); ?>
                    </div>

                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item active"><a class="nav-link" href="#view_member_basic" id="view_member_tab_basic" data-toggle="tab"><?= lang('member.view_member_basic'); ?></a></li>
                            <?php if(!empty($custom_data)) { ?>
                                <li class="nav-item"><a class = "nav-link" href="#view_member_additional" id="view_member_tab_additional" data-toggle="tab"><?= lang('member.view_member_additional'); ?></a></li>
                            <?php }?>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_member_basic">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $label => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($label); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                        </form>
                    </div>

                    <?php if(!empty($custom_data)) { ?>
                        <div class="tab-pane" id = "view_member_additional">
                            <form class="form-horizontal form-groups-bordered" role="form">
                                <?php foreach ($custom_data as $row) { ?>
                                        <div class="form-group">
                                            <label for="" class="control-label col-xs-4"><?= $row['field_name']; ?></label>
                                            <div class="col-xs-6">
                                                <div class="form_view_field"><?= $row['field_value']; ?></div>
                                            </div>
                                        </div>
                                <?php } ?>
                            </form>
                        </div>
                   <?php } ?>

                </div>
            </div>

        </div>
    </div>
</div>