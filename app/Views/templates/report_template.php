<?php 
// echo json_encode($report_fields);
// echo json_encode($report_metadata);
extract($report_metadata);
?>

<style>
    .part_header{
        font-weight: bold;
        text-align: center;
    }
    .message {
        font-size: 12pt;
    }
</style>

<div class="row">
    <div class="col-xs-12 btn-container">
        <div class="btn btn-info btn_back">
            <?= lang('report.back_button') ?>
        </div>
    </div>
</div>

<?php if (session()->get('errors')): ?>
    <div class="form-group">
        <div class="col-xs-12 error">
            <ul>
                <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif ?>


<div class="row hidden message error_container">
    <div class="col-xs-12 error">
        
    </div>
</div>

<div class="row hidden message success_container">
    <div class="col-xs-12 success">
        
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title" style="text-align: center;font-size: 20px;">
                        <i class='fa fa-eye'></i> <?=$report_metadata['assembly_name']. ' ' .$type_name;?> : <?=date('jS F Y',strtotime($report_period));?>
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
                <form id = "frm_report" method="post" action = "<?= site_url('reports/save_report')?>" class="form-horizontal form-groups-bordered" role="form">
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
                                                                <input <?=$data_computed_value;?> <?=$data_field_linked_to;?> class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'] != '' ? $metadata['value'] : 0;?>" <?=$metadata['value'] ? 'readonly' : '';?> />     
                                                            <?php 
                                                                }else{
                                                            ?>
                                                                <input class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>" <?=$metadata['value'] != '' ? 'readonly' : '';?> />     
                                                            <?php
                                                                }
                                                            }elseif($metadata['type'] == 'boolean'){?>

                                                                <span>
                                                                    <input type="checkbox" class = "toggle_btn" data-onstyle='success' data-offstyle='danger'   data-toggle="toggle" <?=$metadata['value'] ? 'checked' : '' ;?> <?=$metadata['value'] != '' ? 'disabled' : '';?> value="<?=$metadata['value'];?>"  data-on="Yes" data-off="No">
                                                                    <input type="hidden" class = "toggle_btn_value" id = "<?=$metadata['field_code'];?>" name="<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>"  />
                                                                </span>
                                                                
                                                            <?php }elseif($metadata['type'] == 'dropdown'){ ?>
                                                                <select class = "form-control" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>">
                                                                    <option value=""><?=lang('report.select_option');?></option>
                                                                    <?php foreach($metadata['options'] as $key => $value){?>
                                                                        <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                                    <?php }?>
                                                                </select>
                                                            
                                                            <?php }else{?>
                                                                <input class = "form-control <?=$metadata['class'];?>" name="<?=$metadata['field_code'];?>" id = "<?=$metadata['field_code'];?>" value="<?=$metadata['value'];?>" <?=$metadata['value'] != '' ? 'readonly' : '';?> />     
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php }?>
                                        </div>
                                        <?php if($i == count($report_fields) - 1 && $report_metadata["requires_mobile_money"] == "yes"){?>
                                            <div class="form-group">
                                                    <label for="paying_number" class="control-label col-xs-4"><?=lang('report.paying_mobile_number');?></label>
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
                                            <button type="submit" class = "btn btn-info" id="save_report"><?=lang('system.save_button_label');?></button>
                                            <button type="submit" class = "btn btn-success" id="submit_report"><?=lang('system.submit_button_label');?></button>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php if($report_metadata["requires_mobile_money"] == "yes") {?>
                    <input type="hidden" name="remitted_amount" id = "remitted_amount" value="" />
                    <?php }?>
                </form>
            </div>

        </div>
    </div>
</div>

<script>

    $(document).on('keydown', '#paying_number', function () {
        const remittance_amount_builder = "<?=$report_metadata['remittance_amount_builder'];?>"
        let initialRemittedAmount  = eval(computeDerivedValues(remittance_amount_builder));
        $("#remitted_amount").val(initialRemittedAmount)
    });

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
                const linkedToTempStr = $(this).data('field_linked_to');
                const linkedIds = linkedToTempStr.split(",", )
                let input = $(this).val()
                let key = e.key;
                
                // Check if the key is a comma
                if (key === ',') {
                    // Prevent the default action (typing the comma)
                    input = input.replace(/,/g, '');
                    $(this).val(input)
                }

                for(let i = 0; i < linkedIds.length; i++){
                    let parentTempStr = $("#"+linkedIds[i]).data('computed_value')

                    if(input){
                    let parentValue = eval(computeDerivedValues(parentTempStr)) 
                    $("#"+linkedIds[i]).val(parentValue)
                }
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
                str = str.replace(match, value !== undefined ? value : 0);
            });
        }

        return str;
    }

    $('#submit_report').on('click', function(e){
        let remitted_amount = $('#remitted_amount').val()
        let paying_number = $('#paying_number').val()
        let message = `Are you sure you want to pay Kes. ${addCommas(remitted_amount)} via paying number ${paying_number}?`

        // if(!isValidNumber(paying_number)){
        //     alert('Please provide a valid paying number')
        //     $('#paying_number').css('border', '1px red solid');
        //     return
        // }

        // $('#modal_confirmation .modal-body').html(message);
        // $("#modal_confirmation").modal("show");
        saveReport()
        e.preventDefault()
    })

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function isValidNumber(input) {
        // Regular expression to match a 10-digit number starting with 0
        const regex = /^0\d{9}$/;
        return regex.test(input);
    }

    $(document).on('click', "#modal_report_save", function () {
        saveReport(true)
    })

    // $('#save_report').on('click', function(){
    //     saveReport()
    // })

    function saveReport($complete_transaction = false){
        const data = $("#frm_report").serializeArray()
        let url =  "<?= site_url('reports/save_report')?>"

        if($complete_transaction){
            url = "<?= site_url('reports/complete_transaction')?>"
        }

        $.ajax({
            url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.hasOwnProperty('errors')) {
                        const error_container = $('.error_container')
                        const success_container = $('.success_container')

                        success_container.addClass('hidden');

                        if (!isEmpty(response.errors)) {
                            error_container.removeClass('hidden');
                            let ul = "<ul>";
                            $.each(response.errors, function (index, value) {
                                ul += "<li>" + value + "</li>";
                            })
                            ul += "</ul>";
                            error_container.find('.error').html(ul);
                        } else {
                            error_container.addClass('hidden');
                        }
                }

                if (response.hasOwnProperty('success')) {
                        const success_container = $('.success_container')
                        const error_container = $('.error_container')

                        error_container.addClass('hidden');

                        if (!isEmpty(response.success)) {
                            const message = "Waiting for the payment confirmation. You will receive a confirmation message shortly."
                            success_container.removeClass('hidden');
                            success_container.find('.success').html(message);

                            $('#modal_confirmation .modal-body').html(response.success);
                            $("#modal_confirmation").modal("show");
                        } else {
                            success_container.addClass('hidden');
                        }
                }

                if (response.hasOwnProperty('complete')) {
                        const success_container = $('.success_container')
                        const error_container = $('.error_container')

                        error_container.addClass('hidden');

                        success_container.removeClass('hidden');
                        success_container.find('.success').html(response.success);

                        $("#modal_confirmation").modal("hide");
                }
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