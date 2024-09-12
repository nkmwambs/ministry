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
                <img src="images/avatar.jpeg" alt="Avatar" class="avatar">
            </div>

            <div class="container">

                <?php if (session()->get('errors')): ?>
                    <div class="col-xs-12 error">
                        <?= session()->getFlashdata('errors');?>
                    </div>
                <?php endif ?>
                
                <label for="uname"><b>User Email</b></label>
                <input type="email" placeholder="Enter Email" value="<?= set_value('email') ?>" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" value="<?= set_value('password') ?>" name="password" required>

                <button type="submit">Login</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>
        <?= form_close() ?>
    </div>
</div>

</body>

</html>