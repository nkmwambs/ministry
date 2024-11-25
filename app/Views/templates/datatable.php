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
        <a href="#" class = "btn btn-success action_add action_btn">Add <?=humanize($feature);?></a>
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
</script>

