<?php 
// echo json_encode($report_fields);
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
                    <input type="hidden" name="report_id" value="<?=$id;?>" />
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
                                                            <?php if($metadata['type'] == 'numeric' || $metadata['type'] == 'text'){
                                                                if($metadata['type'] == 'numeric'){
                                                                    $data_computed_value = '';
                                                                    $data_field_linked_to = '';
                                                                    if($metadata['computed_value']!= null){
                                                                        $data_computed_value = 'data-computed_value="'.$metadata['computed_value'].'"';
                                                                    }

                                                                    if($metadata['field_linked_to']!= null){
                                                                        $data_field_linked_to = 'data-field_linked_to="'.$metadata['field_linked_to'].'"';
                                                                    }
                                                            ?>				
                                                                <input <?=$data_computed_value;?> <?=$data_field_linked_to;?> class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'] != '' ? $metadata['value'] : 0;?>" <?=$metadata['value'] != '' ? 'readonly' : '';?> />     
                                                            <?php 
                                                                }else{
                                                            ?>
                                                                <input class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>" <?=$metadata['value'] != '' ? 'readonly' : '';?> />     
                                                            <?php
                                                                }
                                                            }else{?>

                                                                <span>
                                                                    <input type="checkbox" class = "toggle_btn" data-onstyle='success' data-offstyle='danger'   data-toggle="toggle" <?=$metadata['value'] ? 'checked' : '' ;?> <?=$metadata['value'] != '' ? 'disabled' : '';?> value="<?=$metadata['value'];?>"  data-on="Yes" data-off="No">
                                                                    <input type="hidden" class = "toggle_btn_value" id = "<?=$metadata['field_code'];?>" name="<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>"  />
                                                                </span>
                                                                
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }?>
                                        </div>
                                        
                                        <?php if($i == count($report_fields) - 1){?>
                                            <div class="form-group">
                                                    <label for="paying_number" class="control-label col-xs-4">Paying Number</label>
                                                    <div class="col-xs-6">
                                                        <input type="text" class = "form-control" id = "paying_number" name = "paying_number" />
                                                    </div>
                                            </div> 
                                        <?php
                                        }
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

    $(document).ready(function (e) {
        // Initial tab selection
        $('#<?=$type_code;?>_section_0').addClass('active');

        $('.form-control').each(function () {
            if($(this).data('computed_value')){
                const computingTempStr = $(this).data('computed_value');
                const computedValue = eval(computeDerivedValues(computingTempStr))
                $(this).val(computedValue)
                $(this).prop('readonly', true)
            }

        })

        $('.form-control').on('keyup', function(e){
            if($(this).data('field_linked_to')){
                
                let input = $(this).val()
                const linkedToTempStr = $(this).data('field_linked_to');
                const parentTempStr = $("#"+linkedToTempStr).data('computed_value')
                
                let key = e.key;
                
                // Check if the key is a comma
                if (key === ',') {
                    // Prevent the default action (typing the comma)
                    input = input.replace(/,/g, '');
                    $(this).val(input)
                }

                if(input){
                    const parentValue = eval(computeDerivedValues(parentTempStr)) 
                    // console.log(linkedToTempStr, parentTempStr, parentValue)
                    $("#"+linkedToTempStr).val(parentValue)
                }
            }
        })
    });

    function computeDerivedValues(str){
        let matches = str.match(/\[([^\]]+)\]/g); // Matches everything inside []

        if (matches) {
            // Iterate over each match, replace with value from jQuery selector
            matches.forEach(match => {
                // Remove the square brackets from the match
                let id = match.replace(/[\[\]]/g, '');
                
                // Use jQuery to get the value of the element with the ID
                let value = $(`#${id}`).val();
                
                // Replace the match in the string with the value
                str = str.replace(match, value !== undefined ? value : '');
            });
        }

        return str;
    }

    $('#submit_report').on('click', function(){
        saveReport()
    })

    $('#save_report').on('click', function(){
        saveReport()
    })

    function saveReport(){
        const data = $("#frm_report").serializeArray()
        
        $.ajax({
            url: "<?= site_url('reports/save_report')?>",
            type: 'POST',
            data: data,
            success: function(response) {
                alert('Report saved successfully')
            },
            error: function(xhr, status, error) {
                alert('Failed to save report')
            }
        })
    }

    $(".toggle_btn").on('change', function(){
        // alert('Hello')
        const val = $(this).is(":checked") ? 1 : 0
        $(this).closest('span').find('.toggle_btn_value').val(val);
    })
    
</script>