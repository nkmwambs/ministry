<script>
    const base_url = '<?= site_url(); ?>'

    $(".modal").draggable({
        handle: ".modal-header",
    });

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
        const url = "<?= site_url(); ?>" + plural_feature + "/" + id;
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
                    $('.datepicker').css('z-index', '10200');
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        container: '#modal_ajax modal-body'
                    })
                });

                $('#modal_ajax .modal-body').html(response);
                $("#modal_ajax").modal("show");
            }
        });
    }


    function showAjaxListModal(plural_feature, action, id = '') {

        const url = `<?= site_url() ?>${plural_feature}/modal/${plural_feature}/${action}/${id}`

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

    function showAjaxSelectModal(plural_feature, action, id_segment = 0) {

        const url = `<?= site_url() ?>${plural_feature}/modal/${plural_feature}/${action}/${id_segment}`

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Inject the loaded content into the modal body
                $('#userModal .modal-body').html(response);

                // Show the modal
                $('#userModal').modal('show');

                // Trigger modal display event
                $('#userModal').on('shown.bs.modal', function() {
                    // Initialize Select2 inside the modal
                    $('#permitted_entities').select2({
                        placeholder: 'Select permitted entities',
                        allowClear: true,
                        dropdownParent: $('#userModal') // Ensure Select2 is appended inside the modal
                    });
                });

                // Ensure modal closes and resets form properly (if needed)
                $('#userModal').on('hidden.bs.modal', function() {
                    $(this).find('form')[0].reset();
                    $('#permitted_entities').val(null).trigger('change'); // Clear Select2 selection
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal content:', error);
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
        stateSave: true
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

                // if (!DataTable.isDataTable('.datatable')) {
                $(".datatable").DataTable({
                    stateSave: true
                });
                // }

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


    $(document).ready(function($) {
        // Sample Toastr Notification
        setTimeout(function() {
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
                "toastClass": "black",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("You have been awarded with 1 year free subscription. Enjoy it!", "Account Subcription Updated", opts);
        }, 3000);
    })

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

        const url = `<?= site_url() ?>${plural_feature}/${action}/${item_id}`

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

    // $(document).ready(function() {
    //     $('#permitted_entities').select2({
    //         placeholder: 'Select permitted entities',
    //         allowClear: true
    //     });
    // });
</script>