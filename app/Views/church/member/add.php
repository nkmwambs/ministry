<?php
$numeric_designation_id = hash_id($designation_id, 'decode');
// echo hash_id($parent_id,'decode');
?>
<style>
    
    /* Modal Container */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }    .modal-content {
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        max-height: 80%;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        resize: both;
        overflow-y: auto;
    }

    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 20px;
        color: black;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
    }
    .modal-drag-handle {
        cursor: move;
        background: #f1f1f1;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        border-radius: 10px 10px 0 0;
        font-weight: bold;
    }
</style>

<div id="addMemberModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-plus-circle'></i><?= lang('member.add_member') ?></div>
                </div>
            </div>
            <div class="panel-body">
                <!-- Add your form code here -->
                <form role="form" id="frm_add_member" method="post" action="<?= site_url("members/save") ?>" class="form-horizontal form-groups-bordered">
                    <!-- Your form content as is -->
                    <form role="form" id="frm_add_member" method="post" action="<?= site_url("members/save") ?>" class="form-horizontal form-groups-bordered">

                        <div class="form-group hidden error_container">
                            <div class="col-xs-12 error">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="first_name">
                                <?= lang('member.member_first_name') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Enter First Name">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-xs-4" for="last_name">
                                <?= lang('member.member_last_name') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Enter Last Name">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_gender') ?></label>
                            <div class="col-xs-6">
                                <select class="form-control" name="gender" id="gender">
                                    <option value=""><?= lang('member.member_select_gender') ?></option>
                                    <option value="male"><?php echo lang('system.gender_male'); ?></option>
                                    <option value="female"><?php echo lang('system.gender_female'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for="membership_date" class="control-label col-xs-4"><?= lang('member.membership_date') ?></label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" id="membership_date" name="membership_date" placeholder="Enter Membership Date" />
                            </div>
                        </div>

                        <?php
                        if (isset($parent_id)) {
                        ?>
                            <input type="hidden" name="assembly_id" value="<?= $parent_id; ?>" />
                        <?php
                        } else {
                        ?>
                            <div class="form-group">
                                <label class="control-label col-xs-4" for="assembly_id"><?= lang('member.member_assembly_id') ?></label>
                                <div class="col-xs-6">
                                    <select class="form-control" name="assembly_id" id="assembly_id">
                                        <option value=""><?= lang('assembly.select_assembly') ?></option>

                                    </select>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <!-- <div class="form-group">
  <label class="control-label col-xs-4" for="member_number">
    <?= lang('member.member_member_number') ?>
  </label>
  <div class="col-xs-6">
    <input type="text" class="form-control" name="member_number" id="member_number" placeholder="Enter Member Number"></i>
  </div>
</div> -->

                        <?php if (!$numeric_designation_id) { ?>
                            <div class='form-group'>
                                <label for="designation_id" class="control-label col-xs-4"><?= lang('member.member_designation_id') ?></label>
                                <div class="col-xs-6">
                                    <select class="form-control" name="designation_id" id="designation_id">
                                        <option value=""><?= lang('member.select_designation') ?></option>
                                        <?php foreach ($designations as $designation) : ?>
                                            <option value="<?php echo $designation['id']; ?>"><?php echo $designation['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="designation_id" id="designation_id" value="<?= $parent_id; ?>" />
                        <?php } ?>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="date_of_birth">
                                <?= lang('member.member_date_of_birth') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Enter Date of Birth"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="email">
                                <?= lang('member.member_email') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="phone">
                                <?= lang('member.member_phone') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="email" class="form-control" name="phone" id="phone" placeholder="Enter Phone"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4" for="saved_date">
                                <?= lang('member.saved_date') ?>
                            </label>
                            <div class="col-xs-6">
                                <input type="text" class="form-control datepicker" name="saved_date" id="saved_date" placeholder="Enter Saved Date"></i>
                            </div>
                        </div>


                        <!-- Dynamically Generated Custom Fields -->
                        <?php
                        // echo json_encode($customFields);
                        ?>
                        <?php if ($customFields): ?>
                            <?php foreach ($customFields as $field): ?>
                                <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                                    <label class="control-label col-xs-4" for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
                                    <div class="col-xs-6">
                                        <?php if ($field['options'] != "") { ?>
                                            <select class="form-control" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>">
                                                <option value="">Select Option</option>
                                                <?php
                                                foreach (explode("\r\n", $field['options']) as $option) {
                                                ?>
                                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>" class="form-control" />
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </form>
                </form>
               
            </div>
        </div>
        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="modal_reset" class="btn btn-danger">Reset</button>
                        <button type="button" id="modal_save" data-item_id="" data-feature_plural="" class="btn btn-success">Save</button>
                    </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    $("#modal_reset").on("click", function () {
        // Clear all form inputs inside the modal
        $(this).closest(".modal").find("form")[0].reset();
    });
});

$(document).ready(function () {
    $("#modal_save").on("click", function () {
        const itemID = $(this).data("item_id"); // Retrieve data-item_id
        const featurePlural = $(this).data("feature_plural"); // Retrieve data-feature_plural

        // Gather form data
        const form = $(this).closest(".modal").find("form");
        const formData = form.serialize(); // Serialize form data

        // Submit form data via AJAX
        $.ajax({
            url: "/save", 
            type: "POST",
            data: formData + `&item_id=${itemID}&feature_plural=${featurePlural}`,
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
    });
});

</script>