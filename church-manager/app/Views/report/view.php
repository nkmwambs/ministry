<?php 
echo json_encode($extra_data['report_fields']);
// echo $parent_id;
?>
<div class="row">
    <div class="col-xs-12 btn-container">
        <a href="<?= site_url("reports"); ?>" class="btn btn-info">
            <?= lang('report.back_button') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-eye'></i><?= lang('report.view_report'); ?>
                    </div>
                    <div class="panel-options">
                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="active">
                                <a href="#view_report" id="view_report_tab" data-toggle="tab"><?= lang('report.view_report'); ?></a>
                            </li>
                            <li>
                                <a href="#view_details" id="view_details_tab" data-toggle="tab"><?= lang('report.details'); ?></a>
                            </li>                         
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">
                    <!-- Static report view section -->
                    <div class="tab-pane" id="view_report">
                        <form class="form-horizontal form-groups-bordered" role="form">
                            <?php foreach ($result as $report => $field_value) { ?>
                                <div class="form-group">
                                    <label for="" class="control-label col-xs-4"><?= humanize($report); ?></label>
                                    <div class="col-xs-6">
                                        <div class="form_view_field"><?= ucwords($field_value); ?></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>

                    <div class="tab-pane" id="view_details">
                        
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        // Handle tab clicks and AJAX calls
        $(document).on('click', '.nav-tabs a', function(e) {
            e.preventDefault();
            let tabId = $(this).attr('href').split('#')[1];
            let url  = "<?=site_url('reports/details')?>/<?=$parent_id;?>" // Adjust the URL as needed
       
            // Load the corresponding section view using AJAX
            if(tabId!='view_report'){
                $.ajax({
                    url,
                    success: function(response) {
                        // console.log(response);
                        $("#view_details").html(response);
                    }
                });
            }
            
        });

        // Initial tab selection
        $('#view_report').addClass('active');
    });
</script>