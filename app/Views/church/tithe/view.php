<?php

?>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<div class="row">
    <?php if (session()->getFlashdata('message')) { ?>
        <div class="col-xs-12 info">
            <p><?= session()->getFlashdata('message'); ?></p>
            <a href="<?= site_url(plural($tithe) . '/edit/' . $id) ?>">
                <?= lang('tithe.edit_again_button') ?>
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
                        <i class='fa fa-eye'></i><?= lang('tithe.view_tithe'); ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="view_event">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php
                            if (isset($result['first_name']) && isset($result['last_name'])) {
                                $fullName = $result['first_name'] . ' ' . $result['last_name'];
                            ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize('full_name'); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= $fullName; ?></div>
                                    </div>
                                </div>
                            <?php
                            }

                            foreach ($result as $field_name => $field_value) {
                                if ($field_name == 'first_name' || $field_name == 'last_name') {
                                    continue; 
                                }
                            ?>
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