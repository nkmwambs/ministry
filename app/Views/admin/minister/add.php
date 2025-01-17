<?php
$numeric_assembly_id = hash_id($assembly_id, 'decode');
$numeric_member_id = hash_id($member_id, 'decode');
?>

<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i>
            <?= lang('minister.add_minister') ?>
          </div>
          <div class="panel-options">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#standard" class="nav_tabs" id="standard_tab" data-toggle="tab">Standard</a>
              </li>
              <?php if ($customFields): ?>
                <li><a href="#additional" class="nav_tabs" id="additional_tab" data-toggle="tab">Additional
                    Information</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_minister" method="post" action="<?= site_url("ministers/save") ?>"
          class="form-horizontal form-groups-bordered">

          <!-- <?php if (session()->get('errors')): ?>
              <div class="form-group">
                  <div class="col-xs-12 error">
                    <ul>
                        <?php foreach (session()->get('errors') as $error): ?>
                          <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                  </div>
              </div>
          <?php endif ?> -->

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <div class="tab-content">
            <div class="tab-pane active" id="standard">
              <?php if (!$numeric_assembly_id) { ?>
                <div class='form-group'>
                  <label for="assembly_id"
                    class="control-label col-xs-4"><?= lang('minister.minister_assembly_id') ?></label>
                  <div class="col-xs-6">
                    <select class="form-control" name="assembly_id" id="assembly_id">
                      <option value=""><?= lang('minister.select_assembly') ?></option>
                      <?php foreach ($assemblies as $assembly): ?>
                        <option value="<?php echo $assembly['id']; ?>"><?php echo $assembly['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              <?php } else { ?>
                <input type="hidden" name="assembly_id" id="assembly_id" value="<?= $assembly_id; ?>" />
              <?php } ?>

              <?php if (!$numeric_member_id) { ?>
                <div class='form-group'>
                  <label for="member_id" class="control-label col-xs-4"><?= lang('minister.minister_member_id') ?></label>
                  <div class="col-xs-6">
                    <select class="form-control" name="member_id" id="member_id">
                      <option value=""><?= lang('minister.select_member') ?></option>

                    </select>
                  </div>
                </div>
              <?php } else { ?>
                <input type="hidden" name="member_id" id="member_id" value="<?= $member_id; ?>" />
              <?php } ?>
            </div>

            <div class="tab-pane" id="additional">
              <!-- Dynamically Generated Custom Fields -->
              <?php if ($customFields): ?>
                <?php foreach ($customFields as $field): ?>
                  <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                    <label class="control-label col-xs-4"
                      for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
                    <div class="col-xs-6">
                      <?php if ($field['options'] != "") { ?>
                        <select class="form-control" name="custom_fields[<?= $field['id']; ?>]"
                          id="<?= $field['field_name']; ?>">
                          <option value="">Select Option</option>
                          <?php
                          foreach (explode("\r\n", $field['options']) as $option) {
                            ?>
                            <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                          <?php } ?>
                        </select>
                      <?php } else { ?>
                        <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]"
                          id="<?= $field['field_name']; ?>" class="form-control" />
                      <?php } ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>
</div>

<script>
  $(document).ready(function () {
    const visible = $('.custom_field_container').attr('id');
    console.log(visible);

    if (visible === "no") {
      $('.custom_field_container').addClass('hidden');
    }
  })

  $("#assembly_id").on('change', function () {

    const url = '<?= site_url('ajax') ?>'

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        controller: 'members',
        method: 'get_assembly_minister_members', // makeUser
        data: {
          assembly_id: $(this).val(),
        }
      },
      success: function (response) {

        const members = response.members
        $('#member_id').html('<option value="">Select Member</option>');
        members.forEach(member => {
          $('#member_id').append(`<option value="${member.member_id}">${member.first_name} ${member.last_name} </option>`)
        })

      }
    })

  })

  $(document).ready(function() {
    const countCustomFields = "<?=count($customFields);?>"
    if(countCustomFields > 0){
      $('.modal_action_buttons').addClass('disabled');
    }
  })

  $('.nav_tabs').on('click', function () {
    const tab = $(this)

    if(tab.attr('id') == 'additional_tab'){
      $('.modal_action_buttons').removeClass('disabled');
    }else {
      $('.modal_action_buttons').addClass('disabled');
    }

  });
</script>