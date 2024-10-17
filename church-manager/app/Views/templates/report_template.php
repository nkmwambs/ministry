<style>
    .part_header{
        font-weight: bold;
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("reports"); ?>" class="btn btn-info">
            <?= lang('report.back_button') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('report.view_report'); ?> : <?=$report_prefix;?> : <?=date('jS F Y',strtotime($report_period));?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <?php for ($i = 0; $i < count($report_fields); $i++) { ?>
                                <li class="<?= $i == 0 ? 'active' : ''; ?>">
                                    <a href="#<?=$report_prefix?>_section_<?= $i; ?>" id="section_<?= $i; ?>_tab"
                                        data-toggle="tab"><?= $report_fields[$i]['section_title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <form class="form-horizontal form-groups-bordered" role="form">
                    <div class="tab-content">
                        <!-- Static report view section -->
                        <?php
                        for ($i = 0; $i < count($report_fields); $i++) {
                            ?>
                            <div class="tab-pane" id="<?=$report_prefix?>_section_<?= $i; ?>">
                                <div class="row">
                                    <?php
                                    $section_parts_count = count($report_fields[$i]['section_parts']);
                                    $colSize = 12 / $section_parts_count;
                                    
                                    for ($j = 0; $j < count($report_fields[$i]['section_parts']); $j++) {
                                        ?>
                                        <div class="col-xs-<?= $colSize; ?>">
                                            <div class="form-group" style="text-align:center;">
                                                <div class="part_header"><?=$report_fields[$i]['section_parts'][$j]['part_title'];?></div>
                                            </div>
                                            <?php 
                                                foreach($report_fields[$i]['section_parts'][$j]['part_fields'] as $metadata){
                                                    if(!$metadata) continue;
                                                    
                                            ?>

                                                <div class="form-group">
                                                    <label for="" class="control-label col-xs-4"><?=$metadata['label'];?></label>
                                                    <div class="col-xs-6">
                                                        <div class="input-group form_view_field">
                                                            <div class="input-group-addon">
                                                                <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?=$metadata['helptip'];?>" data-original-title="Help Tip"><i class="entypo-help"></i>
                                                                </a>
                                                            </div>
                                                            <?php if($metadata['type'] == 'numeric' || $metadata['type'] == 'text'){?>				
                                                                    <input class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>" <?=$metadata['value'] != '' ? 'readonly' : ''?> />
                                                            <?php }else{?>
                                                                <input type="checkbox" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" data-toggle="toggle"  data-on="Yes" data-off="No">
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }?>
                                        </div>
                                        <?php
                                    }
                                    
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        // Initial tab selection
        $('#<?=$report_prefix?>_section_0').addClass('active');
    });
</script>