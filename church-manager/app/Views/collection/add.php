<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('collection.add_collection') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_collection" method="post" action="<?= site_url("collection/save") ?>" class="form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <div class="tab">
            <div class="form-group">
              <?= lang("collection.collection_information") ?>
            </div>
            <!-- <div class="form-group"> -->
            <div class="form-group">
              <label class="control-label col-xs-4" for="return_date"><?= lang('collection.collection_return_date') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control datepicker" name="return_date" id="return_date" placeholder="Enter Return Date">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="period_start_date"><?= lang('collection.collection_period_start_date') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="period_start_date" id="period_start_date" placeholder="Enter Period Start Date">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="period_end_date"><?= lang('collection.collection_period_end_date') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control datepicker" name="period_end_date" id="period_end_date" placeholder="Enter Period End Date">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="collection_type_id"><?= lang('collection.collection_collection_type_id') ?></label>
              <div class="col-xs-6">
                <input type="email" oninput="this.className = ''" class="form-control" name="collection_type_id" id="collection_type_id" placeholder="Enter Collection Type Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="amount"><?= lang('collection.collection_amount') ?></label>
              <div class="col-xs-6">
                <input class="text" oninput="this.className = ''" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
              </div>
            </div>
            <!-- </div> -->
          </div>

          <div class="tab">
            <div class="form-group">
                <?= lang("collection.collection_information") ?>
            </div>
            <!-- <div class="form-group"> -->
            <div class="form-group">
              <label class="control-label col-xs-4" for="status"><?= lang('collection.collection_status') ?></label>
              <div class="col-xs-6">
                <input class="text" oninput="this.className = ''" class="form-control" name="status" id="status" placeholder="Enter Status">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="collection_reference"><?= lang('collection.collection_collection_reference') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="collection_reference" id="collection_reference" placeholder="Enter Collection Reference">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="description"><?= lang('collection.collection_description') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="description" id="description" placeholder="Enter Description">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="collection_method"><?= lang('collection.collection_collection_method') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="collection_method" id="collection_method" placeholder="Enter Collection Method">
              </div>
            </div>

            <?php
            if (isset($id)) {
            ?>
              <input type="hidden" name="assembly_id" value="<?= $id; ?>" />
            <?php
            } else {
            ?>
              <!-- <div class="tab"> -->
              <div class="form-group">
                <label class="control-label col-xs-4" for="event_id"><?= lang('collection.collection_assembly_id') ?></label>
                <div class="col-xs-6">
                  <select class="form-control" name="event_id" id="event_id">
                    <option value=""><?= lang('collection.select_collection') ?></option>

                  </select>
                </div>
              </div>
              <!-- </div> -->
            <?php
            }
            ?>
            <!-- </div> -->
          </div>

          <div style="overflow:auto;">
            <div style="float:right;">
              <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
              <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            </div>
          </div>

          <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
          </div>
        </form>
      </div>

    </div>

    </form>

  </div>

</div>

</div>
</div>

<script>
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab

  function showTab(n) {
    // This function will display the specified tab of the form ...
    var $x = $(".tab");
    $x.eq(n).css("display", "block");
    // ... and fix the Previous/Next buttons:
    if (n == 0) {
      $("#prevBtn").css("display", "none");
    } else {
      $("#prevBtn").css("display", "inline");
    }
    if (n == ($x.length - 1)) {
      $("#nextBtn").html("Submit");
    } else {
      $("#nextBtn").html("Next");
    }
    // ... and run a function that displays the correct step indicator:
    fixStepIndicator(n);
  }

  function nextPrev(n) {
    // This function will figure out which tab to display
    var $x = $(".tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    $x.eq(currentTab).css("display", "none");
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form... :
    if (currentTab >= $x.length) {
      //...the form gets submitted:
      $("#frm_add_collection").submit();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }

  function validateForm() {
    // This function deals with validation of the form fields
    var $x, $y, i, valid = true;
    $x = $(".tab");
    $y = $x.eq(currentTab).find("input");
    // A loop that checks every input field in the current tab:
    $y.each(function() {
      // If a field is empty...
      if ($(this).val() == "") {
        // add an "invalid" class to the field:
        $(this).addClass("invalid");
        // and set the current valid status to false:
        valid = false;
      }
    });
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      $(".step").eq(currentTab).addClass("finish");
    }
    return valid; // return the valid status
  }

  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var $x = $(".step");
    $x.removeClass("active");
    //... and adds the "active" class to the current step:
    $x.eq(n).addClass("active");
  }
</script>