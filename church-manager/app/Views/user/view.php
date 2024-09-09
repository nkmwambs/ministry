<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("users"); ?>" class="btn btn-info">
            <?= lang('user.back_button') ?>
        </a>
    </div>
</div>

<div class = "row">
    <?php if(session()->getFlashdata('message') ){?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature)) ?>"><?= lang('user.edit_again_buttton') ?></a>
        </div>
    <?php }?>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('user.view_user'); ?>
                    </div>
                    <div class="panel-options">
							
							<ul class="nav nav-tabs" id ="myTabs">
								<li class = "active"><a href="#view_user" id="view_user_tab" data-toggle="tab"><?= lang('user.view_user'); ?></a></li>
								<li><a href="#view_profile"  data-link_id="view_profile" data-feature_plural="profiles" onclick="childrenAjaxLists(this)" id="view_profile_tab" data-toggle="tab"><?= lang('user.view_profile'); ?></a></li>
                                
                            </ul>
					</div>
                </div>
            </div>
            <div class="panel-body">
                
                <div class="tab-content">
                    <div class="tab-pane active" id="view_user">
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

                    <div class="tab-pane" id="view_profile">
                        <?= include('profile.php') ?>
                    </div>

                    <div class="tab-pane" id="view_password">

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

