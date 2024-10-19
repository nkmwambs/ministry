<?php 
// print_r($parent_id); 
?>

<div class="tab-pane show" id="password" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-database'></i>
                        <?= lang('user.your_data') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="panel-body">
                <button class="btn btn-success" id="data_button" data-item_id="" style="width:100%"><i class="fa fa-download"></i> Download</button>
            </div>
        </div>

    </div>
</div>

<script>
    
    // $(document).on('click',function() {
        // Bind the Download button click
        $('#data_button').click(function() {
            // Redirect to the download route
            window.location.href = "<?= site_url('users/downloadUserData/' . $parent_id); ?>";
        });
    // })
</script>