<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/login.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
</head>
<body>

<div class = "login_container">
    <div class = "login_content">
        <?= form_open(site_url('validate')) ?>
            <div class="imgcontainer">
                <img src="<?=base_url();?>assets/images/logo.png" width="120" alt="" />
                <!-- <img src="images/logo.png" alt="Avatar" class="avatar"> -->
            </div>

            <div class="container">

                <?php if (session()->get('errors')): ?>
                    <div class="col-xs-12 error">
                        <?= session()->getFlashdata('errors');?>
                    </div>
                <?php endif ?>
                
                <!--System Title-->
                <div style="text-align: center;">
                    <h1><?=service('settings')->get('Church.siteName');?></h1>
                </div>
                
                <!-- <label for="uname"><b>User Email</b></label> -->
                <input type="email" placeholder="Enter Email" value="<?= set_value('email') ?>" name="email" required>

                <!-- <label for="psw"><b>Password</b></label> -->
                <input type="password" placeholder="Enter Password" value="<?= set_value('password') ?>" name="password" required>

                <button type="submit"><?= lang('user.login') ?></button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> <?= lang('user.remember_me') ?>
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn"><?= lang('user.cancel') ?></button>
                <span class="psw"><?= lang('user.forgot') ?> <a href="#"><?= lang('user.login') ?></a></span>
            </div>
        <?= form_close() ?>
    </div>
</div>

</body>

</html>