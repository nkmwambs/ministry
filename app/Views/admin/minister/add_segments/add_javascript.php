<script>
  $(document).ready(function () {
    const visible = $('.custom_field_container').attr('id');
    console.log(visible);

    if (visible === "no") {
      $('.custom_field_container').addClass('hidden');
    }
  })

  $("#assembly_id").on('change', function () {

    const url = '<?= site_url('ajax') ?>'

    $.ajax({
      url: url,
      type: 'POST',
      data: {
        controller: 'members',
        method: 'get_assembly_minister_members', // makeUser
        data: {
          assembly_id: $(this).val(),
        }
      },
      success: function (response) {

        const members = response.members
        $('#member_id').html('<option value="">Select Member</option>');
        members.forEach(member => {
          $('#member_id').append(`<option value="${member.member_id}">${member.first_name} ${member.last_name} </option>`)
        })

      }
    })

  })

  $(document).ready(function() {
    const countCustomFields = "<?=count($customFields);?>"
    if(countCustomFields > 0){
      $('.modal_action_buttons').addClass('disabled');
    }
  })

  $('.nav_tabs').on('click', function () {
    const tab = $(this)

    if(tab.attr('id') == 'additional_tab'){
      $('.modal_action_buttons').removeClass('disabled');
    }else {
      $('.modal_action_buttons').addClass('disabled');
    }

  });
</script>