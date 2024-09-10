
<style>
    .center, .heading{
        text-align: center;
        padding-bottom: 20px;
    }

    .heading {
        padding-top: 20px;
        font-weight: bold;
    }
</style>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('role.view_role'); ?>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <div class = "row">
                    <div class = "col-xs-12 center">
                        <?=$result['name'];?>
                    </div>
                </div>

                <form  class="form-horizontal form-groups-bordered">
                    <input type="hidden" name="role_id" id = "role_id" value="<?=$result['id'];?>" />

                    <div class = "form-group">
                        <label for="name" class = "control-label col-xs-4">Choose a feature</label>
                        <div class = "col-xs-4">
                            <select class="form-control" id="feature">
                                <option value="">Select a feature</option>
                                <?php foreach ($features as $feature) :?>
                                <option value="<?php echo $feature['id'];?>"><?php echo humanize($feature['name']);?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <div id = "btn_add_feature" class="btn btn-success">Add</div>
                        </div>
                    </div>
                </form>

                <div class = "row">
                    <div class = "col-xs-12 center heading">
                        Role Permissions
                    </div>
                </div>

                <form  class="form-horizontal form-groups-bordered">
                    <table id="permission_table" class = "table table-striped">
                        <thead>
                            <tr>
                                <th>Features</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($role_assigned_features as $role_assigned_feature){?>
                                <tr>
                                    <td>
                                        <?=humanize($role_assigned_feature['feature_name']);?>
                                    </td>
                                    <td>
                                        <select class="form-control permission_labels" id = "<?=$role_assigned_feature['feature_id'];?>">
                                            <?php foreach(json_decode($role_assigned_feature['allowable_permission_labels']) as $label){ ?>
                                                <option value="<?=$label;?>" <?=$role_assigned_feature['permission_label'] == $label ? 'selected': ''; ?> ><?=$label;?></option>
                                            <?php }?>
                                        </select>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </form> 
                
            </div>
        </div>
    </div>
</div>

<script>

    $(document).on('change', '.permission_labels', function (){
        const permission_label = $(this).val();
        const row_index = $(this).closest('tr').index();
        const feature_id = $(this).attr('id');
        const base_url = "<?=site_url("permissions/update_permission/");?>"
        const role_id = $('#role_id').val()

        $.ajax({
            url: base_url,
            type: 'POST',
            data: {permission_label, feature_id, role_id},
            beforeSend: function(){
                $("#overlay").css("display", "block");
            },
            success: function(response) {
                // console.log(response);
                $("#overlay").css("display", "none");
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })

    $(document).on('click','#btn_add_feature', function (){
        const base_url = "<?=site_url("features/get_allowable_permission_labels/");?>"
        const feature_id = $('#feature').val();

        $.ajax({
            url: base_url + feature_id,
            type: 'GET',
            success: function(response) {
                const labels = JSON.parse(response.allowable_permission_labels);
                // Add a row to the feature table and remove the selected option
                let options = "<option value=''>Select Permission</option>";
                $.each(labels , function(index, elem){
                    options += "<option value='" + elem + "'>" + elem + "</option>";
                })
                
                if(feature_id > 0){
                    var html = '<tr>';
                    html += '<td>'+$('#feature option:selected').text()+'</td>';
                    html += '<td><select class="form-control permission_labels" id="'+feature_id+'" name="permission['+feature_id+']">'+options+'</select></td>';
                    html += '</tr>';
                    $('#permission_table tbody').append(html);

                    // clear the selected option
                    $('#feature').find('option:selected').remove();
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })
</script>