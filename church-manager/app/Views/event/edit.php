<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i><?= lang('event.edit_event') ?></div>
                </div>

            </div>

            <div class="panel-body">
            
                <form id = "frm_edit_event" method="post" action="<?=site_url('events/update/');?>" role="form" class="form-horizontal form-groups-bordered">

                    <div class="form-group hidden error_container">
                        <div class="col-xs-12 error">
                        
                        </div>
                    </div>
                    
                    <input type="hidden" name="id" value="<?=hash_id($result['id']);?>" />

                    <?php if (session()->get('errors')): ?>
                        <div class="form-group">
                            <div class="col-xs-12 error">
                                <ul>
                                    <?php foreach (session()->get('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="event_name">
                            <?= lang('event.event_name') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Edit Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="meeting_id">
                            <?= lang('event.event_meeting_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="meeting_id" id="meeting_id" value="<?=$result['meeting_id'];?>" placeholder="Edit Meeting Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="start_date">
                            <?= lang('event.event_start_date') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" onkeydown="return false;" class="form-control datepicker"
                                name="start_date" id="start_date" value="<?=$result['start_date'];?>" placeholder="Edit Start Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="end_date">
                            <?= lang('event.event_end_date') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" onkeydown="return false;" class="form-control datepicker"
                                name="end_date" id="end_date" value="<?=$result['end_date'];?>" placeholder="Edit End Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="location">
                            <?= lang('event.event_location') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="location" value="<?=$result['location'];?>" id="location"
                                placeholder="Edit Location">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="description">
                            <?= lang('event.event_description') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="description" id="description" value="<?=$result['description'];?>" placeholder="Edit Description">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="denomination_id">
                            <?= lang('event.event_denomination_id') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="denomination_id" id="denomination_id" value="<?=$result['denomination_id'];?>" placeholder="Edit Denomination">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="registration_fees">
                            <?= lang('event.event_registration_fees') ?>
                        </label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="registration_fees" id="registration_fees" value="<?=$result['registration_fees'];?>" placeholder="Edit Registration Fees">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>