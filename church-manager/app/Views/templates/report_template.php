<?php 
// echo json_encode($report_period);
extract($report_metadata);
?>

<style>
    .part_header{
        font-weight: bold;
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('report.view_report'); ?> : <?=$type_name;?> : <?=date('jS F Y',strtotime($report_period));?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <?php for ($i = 0; $i < count($report_fields); $i++) { ?>
                                <li class="<?= $i == 0 ? 'active' : ''; ?>">
                                    <a href="#<?=$type_code?>_section_<?= $i; ?>" id="section_<?= $i; ?>_tab"
                                        data-toggle="tab"><?= $report_fields[$i]['section_title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <form id = "frm_report" class="form-horizontal form-groups-bordered" role="form">
                    <div class="tab-content">
                        <!-- Static report view section -->
                        <?php
                        for ($i = 0; $i < count($report_fields); $i++) {
                            ?>
                            <div class="tab-pane" id="<?=$type_code?>_section_<?= $i; ?>">
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
                                                    <label for="<?=$metadata['field_code'];?>" class="control-label col-xs-4"><?=$metadata['label'];?></label>
                                                    <div class="col-xs-6">
                                                        <div class="input-group form_view_field">
                                                            <div class="input-group-addon">
                                                                <a href="#" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?=$metadata['helptip'];?>" data-original-title="Help Tip"><i class="entypo-help"></i>
                                                                </a>
                                                            </div>
                                                            <?php if($metadata['type'] == 'numeric' || $metadata['type'] == 'text'){?>				
                                                                    <input class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>" <?=$metadata['value'] != '' ? 'readonly' : '';?> />
                                                            <?php }else{?>
                                                                <input type="checkbox" data-onstyle='success' data-offstyle='danger'  name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" data-toggle="toggle" <?=$metadata['value'] ? 'checked' : '' ;?> <?=$metadata['value'] != '' ? 'disabled' : '';?> value="<?=$metadata['value'];?>"  data-on="Yes" data-off="No">
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
                                <div class = "row">
                                    <div class = "col-xs-12" style = "text-align:right;padding-top:20px;">
                                        <?php if($i == count($report_fields) - 1){?>
                                            <div class = "btn btn-info" id="save_report"><?=lang('system.save_button_label');?></div>
                                            <div class = "btn btn-success" id="submit_report"><?=lang('system.submit_button_label');?></div>
                                        <?php }?>
                                    </div>
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
        $('#<?=$type_code;?>_section_0').addClass('active');
    });

    $('#submit_report').on('click', function(){
        saveReport()
    })

    $('#save_report').on('click', function(){
        saveReport()
    })

    function saveReport(){
        const data = $("#frm_report").serializeArray()
        console.log(data)
    }
</script>