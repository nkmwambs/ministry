<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/login.css"/>
</head>
<body>

<div class = "login_container">
    <!-- <div> -->
    <form action="<?=site_url('validate');?>" method="post">
        <div class="imgcontainer">
            <img src="images/avatar.jpeg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname"><b>User Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit">Login</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </form>
    <!-- </div> -->
</div>

</body>

</html>