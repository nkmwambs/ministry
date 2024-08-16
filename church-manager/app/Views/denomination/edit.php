<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="page-title"><i class='fa fa-pencil'></i> Edit Denomination</div>
                </div>

            </div>

            <div class="panel-body">
            
                <form method="post" action="<?=site_url('denominations/update/');?>" role="form" class="form-horizontal form-groups-bordered">
                    
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
                        <label class="control-label col-xs-4" for="denomination_name">Name</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="name" value="<?=$result['name'];?>" id="name"
                                placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="code">Code</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="code" id="code" value="<?=$result['code'];?>" placeholder="Enter Code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="registration_date">Registration Date</label>
                        <div class="col-xs-6">
                            <input type="text" onkeydown="return false;" class="form-control datepicker"
                                name="registration_date" id="registration_date" value="<?=$result['registration_date'];?>" placeholder="Enter Registration Date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="head_office">Head Office</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="head_office" value="<?=$result['head_office'];?>" id="head_office"
                                placeholder="Enter Head Office">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="email">Email</label>
                        <div class="col-xs-6">
                            <input type="email" class="form-control" name="email" id="email" value="<?=$result['email'];?>" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-4" for="phone">Phone</label>
                        <div class="col-xs-6">
                            <input type="text" class="form-control" name="phone" id="phone" value="<?=$result['phone'];?>" placeholder="Enter Phone">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>