<?php
    // require_once('./classes/FBauth.php');
    require_once('./classes/Googleauth.php');

    
?>

<link rel="stylesheet" href="./css/login.css">


<div class="box-login">
    <h2>Area de login</h2>
    <div class="social">
        <a href="./?url=login">Login with facebook</a>
    </div>
    
    <form method="post" action="">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" value="<?php if(isset($_COOKIE['user'])) echo $_COOKIE['user'] ?>" placeholder="Username">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" placeholder="Password">
        
        <input type="submit" name="login" value="Login">
        <div class="w-50" style="display: inline-block; float: right;">
            <label for="remindMe">Remember ?</label>
            <input type="checkbox" name="remindMe" id="remindMe" value="bla" style="height: 1em; width: 1em;">
        </div>
    </form>
</div>
<div class="clear"></div>