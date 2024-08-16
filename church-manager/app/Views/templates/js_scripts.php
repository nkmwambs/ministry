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
        console.log($this);
        const id = $($this).data('item_id');
        const plural_feature = $($this).data('feature_plural');
        const url = "<?= site_url();?>/"+plural_feature+"/" + id;
        getRequest(url, function(response) {
            // $('#list_'+plural_feature).html(response);
            $('.ajax_main').html(response);
            $(".datatable").DataTable({
                stateSave: true
            });
        });
    }

    function showAjaxModal(plural_feature, action, id = ''){

        const url = `<?=site_url()?>${plural_feature}/modal/${plural_feature}/${action}/${id}`

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
                $('#modal_ajax .modal-title').html(capitalizeFirstLetter(action) + ' ' + capitalizeFirstLetter(plural_feature));
                $('#modal_ajax .modal-body').html(response);
                $("#modal_save").data('item_id', id)
                $("#modal_save").data('feature_plural', plural_feature)
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

    $('.datatable').DataTable({
        stateSave: true
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    $(document).on('click', "#modal_save", function(){
        const modal_content= $(this).closest('.modal-content');
        const frm_id = modal_content.find('form').attr('id');
        const frm = $('#' + frm_id)
        const data = frm.serializeArray()
        const url = frm.attr('action')

        $.ajax({
            url,
            type: 'POST',
            data,
            beforeSend: function() {
                $("#overlay").css("display", "block");
            },
            success: function(response){
                $("#modal_ajax").modal("hide");

                if($('.ajax_main').length > 0){
                    $('.ajax_main').html(response);
                }else{
                    $('.main').html(response);
                }
                
                $(".datatable").DataTable({
                    stateSave: true
                });

                $("#overlay").css("display", "none");
            }
        })

    })
</script>