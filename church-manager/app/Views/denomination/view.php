<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("denominations"); ?>" class="btn btn-info">Back</a>
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
                    <div class="page-title"><i class='fa fa-eye'></i><?= lang('denomination.view_denomination'); ?></div>
                </div>
            </div>

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

            <div class="panel-body"></div>

        </div>
    </div>
</div>