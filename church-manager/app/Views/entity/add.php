<?php
// echo json_encode($lookup_items);
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title"><i class='fa fa-plus-circle'></i> Add Entity</div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_entity" method="post" action="<?= site_url("entities/save") ?>" class="form-horizontal form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <input type="hidden" name="hierarchy_id" value="<?= $parent_id; ?>" />

          <div class="form-group">
            <label class="control-label col-xs-4" for="parent_id">Parent Entity</label>
            <div class="col-xs-6">
              <select class="form-control" name="parent_id" id="parent_id">
                <option value="">Select Hierarchy Level</option>
                <?php
                if (isset($parent_entities)) {
                  foreach ($parent_entities as $entity) { ?>
                    <option value="<?= $entity['id']; ?>"><?= $entity['name']; ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group content hidden">
            <label class="control-label col-xs-4" for="name">Name</label>
            <div class="col-xs-6">
              <input type="text" class="form-control" name="name" id="name"
                placeholder="Enter Name" required>
            </div>
          </div>

          <div class="form-group content hidden">
            <label class="control-label col-xs-4" for="entity_leader">Entity Leader</label>
            <div class="col-xs-6">
              <select class="form-control" name="entity_leader" id="entity_leader">
                <option value="">Select Hierarchy Leader</option>
              </select>
            </div>
          </div>

          <!-- Dynamically Generated Custom Fields -->
          <?php if ($customFields): ?>
            <?php foreach ($customFields as $field): ?>
              <div class="form-group custom_field_container" id="<?= $field['visible']; ?>">
                <label class="control-label col-xs-4" for="<?= $field['field_name']; ?>"><?= ucfirst($field['field_name']); ?></label>
                <div class="col-xs-6">
                  <input type="<?= $field['type']; ?>" name="custom_fields[<?= $field['id']; ?>]" id="<?= $field['field_name']; ?>" class="form-control">
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </form>

      </div>

    </div>

  </div>
</div>


<script>
  $("#parent_id").on("change", function() {
    const parent_id = $(this).val();
    const form_groups = $('.content');

    if (parent_id > 0) {
      form_groups.filter('.hidden').removeClass('hidden');
    }
  })
</script>