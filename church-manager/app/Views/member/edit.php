<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title">
                        <i class='fa fa-pencil'></i>
                        <?= lang('member.edit_member') ?>
                    </div>
                </div>

            </div>

            <div class="panel-body">

                <form id="frm_edit_member" method="post" action="<?= site_url('members/update/'); ?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= hash_id($result['id']); ?>" />
                    <input type="hidden" name="assembly_id" value="<?= hash_id($result['assembly_id']); ?>" />

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="first_name">
                            <?= lang('member.member_first_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $result['first_name']; ?>" placeholder="Enter First Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="last_name">
                            <?= lang('member.member_last_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $result['last_name']; ?>" placeholder="Enter Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="member_number">
                            <?= lang('member.member_member_number') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="member_number" id="member_number" value="<?= $result['member_number']; ?>" placeholder="Enter Member Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="designation_id">
                            <?= lang('member.member_designation_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="designation_id" id="designation_id" value="<?= $result['designation_id']; ?>" placeholder="Enter Designation Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="date_of_birth">
                            <?= lang('member.member_date_of_birth') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control datepicker" name="date_of_birth" id="date_of_birth" value="<?= $result['date_of_birth']; ?>" placeholder="Enter Date of Birth">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="email">
                            <?= lang('member.member_email') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="email" id="email" value="<?= $result['email']; ?>" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">
                            <?= lang('member.member_phone') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="phone" id="phone" value="<?= $result['phone']; ?>" placeholder="Enter Phone"></i>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>