<style>
    .section_template{
        margin-top: 10px;
        border: 2px groove #fafafa;
        padding: 5px;
    }
    .layout_title {
        text-align: left;
        font-weight: bold;
    }
</style>

<?php 
$reportLibrary = new \App\Libraries\ReportLibrary();
$fieldsData = $reportLibrary->getReportFields(['denomination_id' => $result['denomination_id']]);
$fields = [];
if(isset($fieldsData['fields']) && !empty($fieldsData['fields'])){
    $fields = $fieldsData['fields'];
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('type.edit_type') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">
                <form id="frm_edit_type" method="post" action="<?=site_url('admin/types/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" id = "type_id" value="<?=$id;?>" />

                    <?php if(!$numeric_denomination_id){?>
                        <div class = 'form-group'>
                            <label for="denomination_id" class = "control-label col-xs-4"><?= lang('denomination.denomination_name') ?></label>
                            <div class = "col-xs-6">
                                <select class = "form-control" name = "denomination_id" id = "denomination_id">
                                    <option value =""><?= lang('denomination.select_denomination') ?></option>
                                    <?php foreach ($denominations as $denomination) :?>
                                        <option value="<?php echo $denomination['id'];?>" <?=$result['denomination_id'] == $denomination['id'] ? 'selected' : ''; ?>><?php echo $denomination['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    <?php }else{?>
                        <input type="hidden" name="denomination_id" id = "denomination_id" value="<?=$parent_id;?>" />
                    <?php }?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang('type.type_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name" value="<?=$result['name'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="type_code">
                            <?= lang('type.type_code') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="type_code" id="type_code" value = "<?=$result['type_code'];?>" readonly >
                        </div>
                    </div>

                    <?php 
                        $report_layout = json_decode($result['report_layout'], true);
                        if(!empty($report_layout)){
                            $section_number = 0;
                            foreach($report_layout as $section){
                    ?>
                                <section class = "section_template">
                                    <div class="form-group section_header">
                                        <div class="layout_title col-xs-6">Section Title</div>
                                        <div class="layout_title col-xs-6">Section Action</div>
                                    </div>
                                    <div class="form-group section_content">
                                        <div class = "col-xs-6 div_section_title">
                                            <input type="text" value = "<?=$section['section_title'];?>" class="form-control section_title" name="layout[<?=$section_number;?>][section_title]" placeholder="Enter Section Title" />
                                        </div>
                                        <div class = "col-xs-6 div_section_title">
                                            <div class="btn btn-success btn_create_parts">Add Part</div>
                                        </div>
                                    </div>

                                    <div class="form-group parts_header">
                                        <div class="layout_title col-xs-6">Part Title</div>
                                        <div class="layout_title col-xs-6">Part Fields</div>
                                    </div>
                                    <section class = "parts">
                                    <?php  
                                        if(isset($section['section_parts'])){ 
                                        $part_number = 0;
                                        foreach($section['section_parts'] as $part){
                                    ?>
                                        
                                            <div class="form-group part_template">
                                                <div class="col-xs-6 div_part_title">
                                                    <div class = "col-xs-2">
                                                        <i style = "color:red;cursor:pointer;" class = "fa fa-minus-circle delete_part"></i>
                                                    </div>
                                                    <div  class = "col-xs-10">
                                                        <input type="text" value="<?=$part['part_title'];?>" class="form-control part_title" name="layout[<?=$section_number;?>][section_parts][<?=$part_number;?>][part_title]" placeholder="Enter Part Title">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 div_part_fields">
                                                    <select name="layout[<?=$section_number;?>][section_parts][<?=$part_number;?>][part_fields][]" class = "form-control multi_fields" multiple>
                                                        <?php 
                                                            if(isset($part['part_fields'])){
                                                                $part_fields = explode(',',$part['part_fields'][0]);
                                                                foreach($fields as $field){
                                                                    $selected = "";
                                                                    foreach($part_fields as $part_field){
                                                                        if($part_field == $field['id']){
                                                                            $selected = 'selected = "selected"';
                                                                        }
                                                                    }  
                                                                        echo "<option value='".$field['id']."' ".$selected.">".$field['text']."</option>";
                                                                    }
                                                            } 
                                                         ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        
                                    <?php 
                                                $part_number++;
                                            }
                                        }
                                    ?>
                                    </section>
                                </section>
                    <?php 
                                $section_number++;
                            }
                        }
                    ?>

                </form> 
            </div>

        </div>

    </div>
</div>

<script>
    $('.multi_fields').select2({
        placeholder: 'Select Fields',
        allowClear: true,
    });

    $(".delete_part").on("click", function() {
        // alert('Hello')
        const part_template = $(this).closest('.part_template')
        part_template.remove();
    })

    
    $(".btn_create_parts").on("click", function (ev) {
        let section_parts_count = $('.part_template').length - 1;
        let part_template = $("#span_part_template").find('.part_template').clone();
        let parts_section = $(this).closest('.section_template').find('.parts'); // $(this).parent().closest(".form-group").siblings('.parts');
        // let parts_header = $(this).parent().closest(".form-group").siblings(".parts_header")
        let section_number = $('.section_template').length - 1; //$(this).parent().siblings(".section_number").val();
        let denomination_id = $("#denomination_id").val()
        let url = "<?= site_url('ajax')?>";

        console.log(section_parts_count)

        // if(parts_section.children().length == 0) {
            // parts_header.removeClass("hidden");
            
            $.ajax({
                url,
                method: 'POST',
                data: {
                    controller: 'reports',
                    method: 'getReportFields',
                    data: {
                        denomination_id: denomination_id
                    }
                },
                success: function(response) {
                    const fields = response.fields;
                    let part = part_template.clone();
                    part.removeClass("hidden");
                    part.find('.part_number').val(section_parts_count);

                    part.find('.div_part_title').find('.part_title').prop('name', `layout[${section_number}][section_parts][${section_parts_count}][part_title]`)
                    part.find('.div_part_fields').find('.part_fields').prop('name', `layout[${section_number}][section_parts][${section_parts_count}][part_fields][]`)

                    part.find('.dynamic_multi_fields').select2({
                        placeholder: 'Select Fields',
                        allowClear: true,
                        multiple: true,
                        data: fields
                    });

                    parts_section.append(part);
                }
            })
            
        // }
        ev.preventDefault();
    });

</script>


<span id = "span_part_template">
    <div class = "form-group part_template hidden">
        <div class="col-xs-6 div_part_title">
            <input type="text" class="form-control part_title" name=""  placeholder="<?= lang('type.enter_part_title') ?>">
        </div>

        <div class="col-xs-6 div_part_fields">
            <input class="form-control part_fields dynamic_multi_fields" name=""  />
        </div>
        <input type="hidden" class="part_number" placeholder="<?= lang('type.enter_part_number') ?>" />
    </div>
</span>