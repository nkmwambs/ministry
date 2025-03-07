<?=$this->renderSection('style');?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-plus-circle'></i>
                        <?= $this->renderSection('pageTitle'); ?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#standard" class="nav_tabs" id="standard_tab"
                                    data-toggle="tab">Basic Information</a>
                            </li>
                            <?php if ($customFields): ?>
                                <li><a href="#additional" class="nav_tabs" id="additional_tab" data-toggle="tab">Additional
                                        Information</a></li>
                            <?php endif; ?>
                            <?= $this->renderSection('navTabs'); ?>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm_add_<?=singular($tableName);?>" method="post"
                    action="<?= site_url($tableName."/save") ?>"
                    class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error"></div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane active" id="standard">
                            <?= $this->renderSection('standardPaneContent'); ?>
                        </div>

                        <div class="tab-pane" id="additional">
                            <?= $this->renderSection('additionalPaneContent'); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->renderSection('javascript'); ?>
