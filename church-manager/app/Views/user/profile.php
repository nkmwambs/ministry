<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="col-md-3 col-xl-3">
                <?= view('user/profile_nav.php'); ?>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="tab-content">
                    <?= $content; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- <script> -->
    // $(document).ready(function () {
    //     $('.list-group-item').on('click', function (e) {
    //         e.preventDefault();
            
    //         let url = $(this).attr('href'); 
    //         $.get(url, function (data) {
    //             $('.tab-content').html(data); 
    //         });
    //     });

    //     $('.list-group-item:first').trigger('click');
    // });
<!-- </script> -->
