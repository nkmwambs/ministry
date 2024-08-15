<script>

    function getRequest(url, on_success){
        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: function() {
                $("#overlay").css("display", "block");
            }
        }).done(function(response) {
            on_success(response);
        }).fail(function(xhr, status, error) {
            alert('Error has occurred');
        }).always(function() {
            $("#overlay").css("display", "none");
        });
    }


     function postRequest(url, data, on_success){
        $.post({
            url: url,
            data: data,
            beforeSend: function() {
                $("#overlay").css("display", "block");
            }
        }).done(function(response) {
            on_success(response);
        }).fail(function(xhr, status, error) {
            alert('Error has occurred');
        }).always(function() {
            $("#overlay").css("display", "none");
        });
    }


    function childrenAjaxLists($this){
        const id = $($this).data('item_id');
        const plural_feature = $($this).data('feature_plural');
        const url = "<?= site_url();?>/"+plural_feature+"/" + id;
        getRequest(url, function(response) {
            $('#list_'+plural_feature).html(response);
            $(".datatable").DataTable();
        });
    }

    function showAjaxModal(feature, action, id = ''){

        const url = `<?=site_url()?>${feature}/modal/${feature}/${action}/${id}`

        $('#modal_ajax').on('shown.bs.modal', function() {
            $('.datepicker').css('z-index','10200');
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                container: '#modal_ajax modal-body'
            })
        });
                
        
         $.ajax({
             url,
             success: function(response) {
                $('#modal_ajax .modal-title').html(capitalizeFirstLetter(action) + ' ' + capitalizeFirstLetter(feature));
                $('#modal_ajax .modal-body').html(response);
                $("#modal_ajax").modal("show");
             }
         });
    }


    function capitalizeFirstLetter(word){
        const capitalized =
                word.charAt(0).toUpperCase()
                + word.slice(1)
        return capitalized;
    }

    $('.datatable').DataTable();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $(document).on('click', "#modal_save", function(){
        const modal_content= $(this).closest('.modal-content');
        const frm_id = modal_content.find('form').attr('id');
        const frm = $('#' + frm_id)
        const data = frm.serializeArray()
        const url = frm.attr('action')

        // console.log(data);

        $.ajax({
            url,
            type: 'POST',
            data,
            success: function(response){
                $("#modal_ajax").modal("hide");
                // childrenAjaxLists($('.modal-title a'));
                location.reload();
            }
        })

    })
</script>