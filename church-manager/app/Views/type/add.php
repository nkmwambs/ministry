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
$numeric_denomination_id = hash_id($parent_id, 'decode');
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-plus-circle'></i>
                        <?= lang('type.add_type') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form role="form" id="frm-view_types" method="post" action="<?= site_url("types/save") ?>" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <?php if (!$numeric_denomination_id) { ?>
                        <div class='form-group'>
                            <label for="denomination_id" class="control-label col-xs-4"><?= lang('event.event_denomination_id') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="denomination_id" id="denomination_id">
                                    <option value=""><?= lang('event.select_denomination') ?></option>
                                    <?php foreach ($denominations as $denomination) : ?>
                                        <option value="<?php echo $denomination['id']; ?>"><?php echo $denomination['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="denomination_id" id="denomination_id" value="<?= $parent_id; ?>" />
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="name">
                            <?= lang("type.type_name") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="type_code">
                            <?= lang("type.type_code") ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="type_code" id="type_code" placeholder="Enter Type Code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="section_count">
                            <?= lang("type.section_count") ?>
                        </label>
                        <div class="col-xs-4">
                            <input type="number" class="form-control" name="section_count" id="section_count"
                                placeholder="Enter Section Count">
                        </div>
                        <div class="col-xs-4">
                            <div class="btn btn-success" id = "create_layout">Create Layout</div>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

<script>
    
    $("#create_layout").click(function () {
        let section_count = $("#section_count").val();
        let section_template = $(".section_template").clone();

        for (let i = 0; i < section_count; i++) {
            let section = section_template.clone();
            section.removeClass("hidden");
            section.find('.section_content').find('.section_number').val(i)
            section.find('.section_content').find('.div_section_title').find('.section_title').prop('name', `layout[${i}][section_title]`)
            $("#frm-view_types").append(section);
        }
    });


    $(document).on("click",".btn_create_parts", function (ev) {
        let section_parts_count = $(this).parent().siblings(".div_section_parts_count").find('.section_parts_count').val();
        let part_template = $("#span_part_template").find('.part_template').clone();
        let parts_section = $(this).parent().closest(".form-group").siblings('.parts');
        let parts_header = $(this).parent().closest(".form-group").siblings(".parts_header")
        let section_number = $(this).parent().siblings(".section_number").val();
        let denomination_id = $("#denomination_id").val()

        let url = "<?= site_url('ajax')?>";

        // alert(section_parts_count)
       
        if(parts_section.children().length == 0) {
            parts_header.removeClass("hidden");
            
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
                    for (let i = 0; i < section_parts_count; i++) {
                        let part = part_template.clone();
                        // console.log(part);
                        let partNum = i
                        let multiClass = 'multi_fields_' + section_number + '_' + i
                        let partClass = 'part_' + section_number + '_' + i
                        part.removeClass("hidden");
                        part.find('.part_number').val(i);

                        part.find('.div_part_title').find('.part_title').prop('name', `layout[${section_number}][section_parts][${i}][part_title]`)
                        part.find('.div_part_fields').find('.part_fields').prop('name', `layout[${section_number}][section_parts][${i}][part_fields][]`)

                        part.find('.multi_fields').select2({
                            placeholder: 'Select Fields',
                            allowClear: true,
                            multiple: true,
                            data: fields
                        });

                        parts_section.append(part);
                    }
                }
            })
            
        }
        ev.preventDefault();
    });

</script>

<!-- Section Template -->
<section class = "hidden section_template">
    <div class = "form-group section_header">
        <div class = "layout_title col-xs-4" for="">Section Title</div>
        <div class = "layout_title col-xs-4" for="">Section Parts Count</div>
        <div class = "layout_title col-xs-4" for="">Action</div>
    </div>
    <div class = "form-group section_content">
        <div class="col-xs-4 div_section_title">
            <input type="text" class="form-control section_title" name="" placeholder="Enter Section Title">
        </div>
        <div class="col-xs-4 div_section_parts_count">
            <!-- <input type="number" class="form-control section_parts_count" placeholder="Enter Section Parts Count">   -->
             <select class="form-control section_parts_count">
                <option value = "1">1</option>
                <option value = "2">2</option>
                <option value = "3">3</option>
                <option value = "4">4</option>
             </select>
        </div>
        <div class="col-xs-4">
            <div class="btn btn-success btn_create_parts">Create Parts</div>
        </div>
        <input type="hidden" class="section_number" placeholder="Section Number" />
    </div>

    <div class = "form-group parts_header hidden">
        <div class = "layout_title col-xs-6" for="">Part Title</div>
        <div class = "layout_title col-xs-6" for="">Fields</div>
    </div>

    <section class = "parts"></section>
    
</section>


<span id = "span_part_template">
    <div class = "form-group part_template hidden">
        <div class="col-xs-6 div_part_title">
            <input type="text" class="form-control part_title" name=""  placeholder="Enter Part Title">
        </div>

        <div class="col-xs-6 div_part_fields">
            <!-- <select class="form-control multi_fields" name="part_fields[]" id="part_fields" multiple>
                <option value="">Select Fields</option>
            </select> -->
            <input class="form-control part_fields multi_fields" name=""  />
        </div>
        <input type="hidden" class="part_number" placeholder="Part Number" />
    </div>
</span>

