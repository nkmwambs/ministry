<style>
    .header_label {
        font-weight: bold;
        text-align: center;
    }

    .center {
        text-align: center;
        padding-bottom: 10px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang("member.bulk_edit_$tableName") ?>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <form id="frm_bulk_edit_records" action = "<?=site_url("$tableName/bulk_edit");?>" class="form-horizontal form-groups-bordered" role="form" method="post"
                    action="<?php echo site_url("$tableName/bulk_edit"); ?>">
                    <input type="hidden" name="table_name" value="<?php echo $tableName;?>" />
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?= lang("member.selected_$tableName"); ?></label>
                        <div class="col-sm-10">
                            <select id="bulk_edit_select" name="edit_selected_ids[]" class="form-control select_fields"
                                multiple="multiple">
                                <?php foreach ($selectedItems as $item): ?>
                                    <option value="<?php echo $item['id']; ?>" selected>
                                        <?php echo $item['first_name'] . " " . $item['last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 center">
                            <div class="btn btn-success" id ="add_rows">Add Field to Update</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-2 header_label">Action</div>
                        <div class="col-xs-4 header_label">Field</div>
                        <div class="col-xs-4 header_label">Value</div>
                    </div>

                    <section id = "field_rows" style="padding-top:10px;">

                    </section>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#add_rows').on('click', function(){
        const cloned_field_template = $('#field_template').clone();
        $('#field_rows').append(cloned_field_template.html());
    })

    $(document).on('change',".field", function(){
        // Get the data attribute for selected option 
        const select = $(this)
        const selected_value = select.val();
        const fields = '<?=json_encode($bulkActionFields);?>'
        const jsonObj = JSON.parse(fields)
        $.each(jsonObj, function(key, value){
            if(value.name === selected_value){
                let field_type = value.type;

                select.closest('.form-group').find('.div_value').append('<input type="text" class="form-control value" name="value[]" placeholder="<?php echo lang("system.enter_value"); ?>" />');

                if(field_type === 'date'){
                    select.closest('.form-group').find('.div_value').find('.value').remove()
                    select.closest('.form-group').find('.div_value').append('<input type="date" class="form-control value" name="value[]" placeholder="<?php echo lang("system.enter_value"); ?>" />');
                }else if(field_type === 'enum' || field_type === 'dropdown' || field_type === 'boolean'){
                    let default_value = value.default
                    // Add enum options
                    select.closest('.form-group').find('.value').remove()
                    select.closest('.form-group').find('.div_value').append('<select class="form-control value" name="value[]"></select>')
                    $.each(value.options, function(key, value){
                        select.closest('.form-group').find('.value').append(`<option value="${value}" ${value == default_value ? "selected" : ""} >${value}</option>`)
                    })
                }else if(field_type === 'numeric' || field_type === 'int' || field_type === 'float'){
                    select.closest('.form-group').find('.div_value').find('.value').remove()
                    select.closest('.form-group').find('.div_value').append('<input type="numeric" class="form-control value" name="value[]" placeholder="<?php echo lang("system.enter_value"); ?>" />');
                }
            }
        });
    })

    
</script>

<section id = "field_template" class = "hidden">
    <div class="form-group">
        <div class="col-xs-2">
            <div class="btn btn-danger">Delete</div>
        </div>
        <div class="col-xs-4">
            <select class="form-control field" name="field[]" >
                <option value=""><?= lang("system.select_field_to_update"); ?></option>
                <?php foreach ($bulkActionFields as $field): ?>
                    <option value="<?php echo $field->name; ?>"><?php echo humanize(count(explode("__",$field->name)) > 1 ? explode("__",$field->name)[1]: explode("__",$field->name)[0]);?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-xs-4 div_value"></div>
    </div>
</section>
