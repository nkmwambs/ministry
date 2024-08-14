<?php 
    log_message('error', json_encode($result));
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("ministers"); ?>" class="btn btn-info">
            <?= lang("minister.back_button") ?> <!-- Back Button -->
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-eye'></i>
                        <?= lang('minister.view_minister'); ?> <!-- View button -->
                    </div>
                </div>
            </div>

            <form class="form-horizontal form-groups-bordered" role="form">
                <?php foreach($result as $field_name => $field_value) { ?>
                    <div class = "form-group">
                        <label for="" class = "control-label col-xs-4"><?=humanize($field_name);?></label>
                        <div class = "col-xs-6">
                            <div class = "form_view_field"><?=$field_value;?></div>
                        </div>
                    </div>
                <?php } ?>
            </form>

            <div class="panel-body"></div>

        </div>
    </div>
</div>