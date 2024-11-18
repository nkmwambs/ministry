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

<script>
        
</script>