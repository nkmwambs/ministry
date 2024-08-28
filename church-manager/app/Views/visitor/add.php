<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
          <div class="page-title">
            <i class='fa fa-plus-circle'></i>
            <?= lang('visitor.add_visitor') ?>
          </div>
        </div>

      </div>

      <div class="panel-body">

        <form role="form" id="frm_add_visitor" method="post" action="<?= site_url("visitor/save") ?>" class="form-groups-bordered">

          <div class="form-group hidden error_container">
            <div class="col-xs-12 error">

            </div>
          </div>

          <div class="tab">
            <div class="form-group">
              <?= lang("visitor.personal_information") ?>
            </div>
            <!-- <div class="form-group"> -->
            <div class="form-group">
              <label class="control-label col-xs-4" for="first_name"><?= lang('visitor.visitor_first_name') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="last_name"><?= lang('visitor.visitor_last_name') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="phone"><?= lang('visitor.visitor_phone') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="email"><?= lang('visitor.visitor_email') ?></label>
              <div class="col-xs-6">
                <input type="email" oninput="this.className = ''" class="form-control" name="email" id="email" placeholder="Enter Email">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="gender"><?= lang('visitor.visitor_gender') ?></label>
              <div class="col-xs-6">
                <input class="text" oninput="this.className = ''" class="form-control" name="gender" id="gender" placeholder="Enter Gender">
              </div>
            </div>
            <!-- </div> -->
          </div>

          <div class="tab">
            <div class="form-group">
              <?= lang("visitor.personal_information") ?>
            </div>
            <!-- <div class="form-group"> -->
            <div class="form-group">
              <label class="control-label col-xs-4" for="date_of_birth"><?= lang('visitor.visitor_date_of_birth') ?></label>
              <div class="col-xs-6">
                <input class="text" oninput="this.className = ''" class="form-control datepicker" name="date_of_birth" id="date_of_birth" placeholder="Enter Date of Birth">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="payment_id"><?= lang('visitor.visitor_payment_id') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="payment_id" id="payment_id" placeholder="Enter Payment Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="payment_code"><?= lang('visitor.visitor_payment_code') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="payment_code" id="payment_code" placeholder="Enter Payment Code">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-xs-4" for="registration_amount"><?= lang('visitor.visitor_registration_amount') ?></label>
              <div class="col-xs-6">
                <input type="text" oninput="this.className = ''" class="form-control" name="registration_amount" id="registration_amount" placeholder="Enter Registration Amount">
              </div>
            </div>

            <?php
            if (isset($id)) {
            ?>
              <input type="hidden" name="event_id" value="<?= $id; ?>" />
            <?php
            } else {
            ?>
              <!-- <div class="tab"> -->
              <div class="form-group">
                <label class="control-label col-xs-4" for="event_id"><?= lang('event.event_name') ?></label>
                <div class="col-xs-6">
                  <select class="form-control" name="event_id" id="event_id">
                    <option value=""><?= lang('visitor.select_event') ?></option>

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
      $("#frm_add_visitor").submit();
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