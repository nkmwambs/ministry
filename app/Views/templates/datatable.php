<style>
    .action_btn {
        margin-left: 5px;
    }
    .action_add {
        margin-bottom: 10px;
    }
</style>

<?php if(auth()->user()->canDo("$feature.create")){?>
<div class="row">
    <div class="col-md-12">
        <a href="#openAddMemberModal" class = "btn btn-success action_add action_btn btn btn-primary" id="openAddMemberModal" >Add <?=humanize($feature);?></a>
    </div>
</div>
<?php }?>

<div class="row">
    <div class="col-md-12">
    <table id="<?=$table_id;?>" class="table table-bordered table-striped table-hover tabs_datatable">
    <thead>
        <tr>
            <?php foreach ($columns as $column) { ?>
                <th><?=humanize($column); ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody></tbody>
</table>
    </div>
</div>

<script>
    $(document).on("click",".action_delete", function(){
        const hash_id = $(this).data("id");
        const url = '<?=site_url("church/".plural($feature)."/delete/")?>'+ hash_id;
        const row = $(this).closest("tr")

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // alert("Item deleted successfully.")
                row.remove();
            }
        })

        console.log(url)
    })

     $(document).ready(function () {
        
        // Button click event
        $('#openAddMemberModal').on('click', function (e) {
            e.preventDefault(); // Prevent default action
    
            // Check if the modal already exists in the DOM
            if ($('#addMemberModal').length === 0) {
                // Fetch the modal content via AJAX
                $.ajax({
                    url: '<?= site_url("church/".plural($feature)."/add/") ?>', // Route to fetch modal content
                    type: 'GET',
                    success: function (response) {
                        // Append the modal to the body
                        $('body').append(response);
    
                        // Show the modal
                        $('#addMemberModal').fadeIn();
    
                        // Add event to close the modal
                        $('.close').on('click', function () {
                            $('#addMemberModal').fadeOut(function () {
                                $(this).remove(); // Remove the modal from the DOM
                            });
                        });

                    },
                    error: function (xhr) {
                        console.error("Failed to load modal content:", xhr.responseText);
                    }
                });
            } else {
                // Show the modal if it already exists
                $('#addMemberModal').fadeIn();
            }
        });
    });

</script>

