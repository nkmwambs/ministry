<script>
     $(document).on("click", ".remove_tithe_button", function () {
    $(this).parent().parent().remove();
  })

  $(document).on("click", ".add_tithe_button", function () {
    var new_row = $('.section-content').eq(0).clone();

    // new_row.find('input').val('');
    new_row.find('input[type="text"]').val('');
    new_row.find('input[type="number"]').val('');

    new_row.find('.add_tithe_button').remove();
    new_row.find('.remove_tithe_button').removeClass('hidden');

    new_row.appendTo('.tithe_section');
  })
</script>