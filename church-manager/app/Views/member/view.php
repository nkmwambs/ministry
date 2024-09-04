<?php 
$visitor_sections = array_pop($result);
?>

<div class = "row">
    <?php if(session()->getFlashdata('message') ) { ?>
        <div class = "col-xs-12 info">
            <p><?= session()->getFlashdata('message');?></p>
            <a href="<?= site_url(plural($feature).'/edit/' . $id) ?>">
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
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_event">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $field_name => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($field_name); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $field_value; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>