<script>

  $(document).on("click", ".remove_collection_button", function () {
    $(this).parent().parent().remove();
  })

  $(document).on("click", ".add_collection_button", function () {
    var new_row = $('.section-content').eq(0).clone();

    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="number"]').val('');

    new_row.find('.add_collection_button').remove();
    new_row.find('.remove_collection_button').removeClass('hidden');

    new_row.appendTo('.collection_section');
  })

  $(document).ready(function () {
        $('.reporting_datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "<?=date('Y-m-01', strtotime($currentReportingMonth));?>",
            endDate: "<?=date('Y-m-t', strtotime($currentReportingMonth));?>"
        });
    });
</script>