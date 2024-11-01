<script>
    const base_url = '<?= site_url(service('session')->user_type); ?>/'

    // Drag the modals
    $(".modal").draggable({
        handle: ".modal-header",
    });

    // Resize the modal according number of properties
    $(".modal").resizable();


    function getRequest(url, on_success) {
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


    function postRequest(url, data, on_success) {
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


    function childrenAjaxLists($this) {
        const id = $($this).data('item_id');
        const plural_feature = $($this).data('feature_plural');
        const url = `${base_url}${plural_feature}/list/${id}`
        const link_id = $($this).data('link_id');

        // alert(url)

        getRequest(url, function(response) {
            $('#' + link_id).html(response);
            $('#' + link_id + " .datatable").DataTable({
                stateSave: true
            });

        });
    }


    function showAjaxModal(routes_group, action, id_segment = 0) {

        const url = `${base_url}${routes_group}/modal/${routes_group}/${action}/${id_segment}`
        // alert(url)
        $.ajax({
            url,
            success: function(response) {
                $('#modal_ajax').on('shown.bs.modal', function() {
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        container: '#modal_ajax modal-body',
                        autoclose: true
                    });

                    $('.collection_datepicker').datepicker({
                        beforeShowDay: function(date) {
                            var today = new Date()
                            var day = date.getDay();

                            if (day === 0 && date <= today) {
                                return [true, '', "Available"];
                            } else {
                                return [false, '', 'Unavailable'];
                            }
                        },
                        dateFormat: "yy-mm-dd", // Format for the selected date
                        autoclose: true
                        // minDate: 0, // Disable past dates
                        // maxDate: "+1Y" // Limit selection to 1 year ahead
                    });

                    $('select.select_fields').select2();
                });

                $('#modal_ajax .modal-body').html(response);

                $("#modal_ajax").modal("show");
            }
        });
    }

    $("#modal_ajax").on('hidden.bs.modal', function() {
        // $(this).data('bs.modal', null);
        // window.location.reload();
    });


    function showAjaxListModal(plural_feature, action, id = '') {

        const url = `${base_url}${plural_feature}/modal/${plural_feature}/${action}/${id}`

        $('#modal_list_ajax').on('shown.bs.modal', function() {
            $('.datepicker').css('z-index', '10200');
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                container: '#modal_ajax modal-body'
            })
        });


        $.ajax({
            url,
            success: function(response) {
                // $('.datatable').destroy();
                $('#modal_list_ajax .modal-title').html(capitalizeFirstLetter(action) + ' ' + capitalizeFirstLetter(plural_feature));
                $('#modal_list_ajax .modal-body').html(response);
                $("#modal_list_ajax").modal("show");

                $('.modal_datatable').DataTable({
                    stateSave: true
                })

            }
        });
    }

    function showAjaxBulkAction(plural_feature, actionOnItem, selectedItems) {

        const url = `${base_url}${plural_feature}/getFields/${plural_feature}/${actionOnItem}`

        $('#modal_ajax').on('shown.bs.modal', function() {
            $('.datepicker').css('z-index', '10200');
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                container: '#modal_ajax modal-body'
            })
            $('select.select_fields').select2();
        });

        $.ajax({
            url,
            method: 'POST',
            data: {selectedItems},
            success: function(response) {
                $('#modal_ajax .modal-title').html('Bulk ' + capitalizeFirstLetter(actionOnItem) + ' ' + capitalizeFirstLetter(plural_feature));
                $('#modal_ajax .modal-body').html(response);
                $("#modal_ajax").modal("show");

                $('.modal_datatable').DataTable({
                    stateSave: true
                })

            }
        });
    }

    function capitalizeFirstLetter(word) {
        const capitalized =
            word.charAt(0).toUpperCase() +
            word.slice(1)
        return capitalized;
    }


    $('.datatable').DataTable({
        stateSave: true,
        scrollY: '200px',
        scrollCollapse: true,
        fixedColumns: true,
        fixedHeader: true,
        responsive: true,
        // dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        // deferLoading: 57,
        // processing: true,
        // serverSide: true,
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });


    $(document).on('click', "#modal_save", function() {
        const modal_content = $(this).closest('.modal-content');
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
            success: function(response) {
                // console.log(response);
                if (typeof response == 'object') {

                    if (response.hasOwnProperty('errors')) {
                        const error_container = $('.error_container')

                        if (!isEmpty(response.errors)) {
                            error_container.removeClass('hidden');
                            let ul = "<ul>";
                            $.each(response.errors, function(index, value) {
                                ul += "<li>" + value + "</li>";
                            })
                            ul += "</ul>";
                            error_container.find('.error').html(ul);
                        } else {
                            error_container.addClass('hidden');
                        }
                    }

                    $("#overlay").css("display", "none");

                    return false;
                }

                $("#modal_ajax").modal("hide");

                if ($('.ajax_main').length > 0) {
                    $('.ajax_main').html(response);
                } else {
                    $('.main').html(response);

                    const list_alert_container = $('.list-alert-container');
                    if (list_alert_container.hasClass('hidden')) {
                        list_alert_container.removeClass('hidden');
                        list_alert_container.find('.info').html('Operation successfully')
                    }
                }

                $('.datatable').DataTable().destroy();

                $(".datatable").DataTable({
                    stateSave: true
                });

                $("#overlay").css("display", "none");
            }
        })

    })

    function isEmpty(obj) {
        for (const prop in obj) {
            if (Object.hasOwn(obj, prop)) {
                return false;
            }
        }

        return true;
    }


    $(document).on('click', "#myTabs", function(ev) {
        const tabs = $(this)
        const target_tab = $(ev.target).attr('href')
        const tab_content = $('.tab-content')
        const tab_panes = tab_content.find('.tab-pane')

        $.each(tab_panes, function(index, pane) {
            // console.log(pane)
            $(pane).removeClass('ajax_main')
            $(pane).removeClass('active')
        })

        $(target_tab).addClass('ajax_main')
        $(target_tab).addClass('active')
    })


    function deleteItem(plural_feature, action, item_id) {

        const url = `${base_url}${plural_feature}/${action}/${item_id}`

        $("#delete_confirmation").modal("show");

        $("#confirmDeleteBtn").click(function() {
            $.ajax({
                url,
                method: "GET",
                success: function(response) {
                    // console.log(response)
                    // childrenAjaxLists($('.ajax_main'))
                    $("#delete_confirmation").modal("hide");
                }
            })
        })


    }


    $(document).on('keydown', '.datepicker', function() {
        return false;
    })


    $(document).ready(function($) {

        $(".btn_back").on('click', function() {
            window.history.back();
        })

        // Sample Toastr Notification
        // setTimeout(function() {
        //     var opts = {
        //         "closeButton": true,
        //         "debug": false,
        //         "positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
        //         "toastClass": "black",
        //         "onclick": null,
        //         "showDuration": "300",
        //         "hideDuration": "1000",
        //         "timeOut": "5000",
        //         "extendedTimeOut": "1000",
        //         "showEasing": "swing",
        //         "hideEasing": "linear",
        //         "showMethod": "fadeIn",
        //         "hideMethod": "fadeOut"
        //     };

        //     toastr.success("You have been awarded with 1 year free subscription. Enjoy it!", "Account Subcription Updated", opts);
        // }, 3000);

        // $('.list-group-item').on('click', function (e) {
        //     e.preventDefault();

        //     let url = $(this).attr('href'); 
        //     $.get(url, function (data) {
        //         $('.tab-content').html(data); 
        //     });
        // });

        // $('.list-group-item:first').trigger('click');
    })
</script>