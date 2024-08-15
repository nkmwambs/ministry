<script>
    $('.datatable').DataTable();

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

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

</script>