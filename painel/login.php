<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel de controle</title>
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="./css/login.css">
    <style>
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', Times, serif;
        }
        body{
            height: 100%;
            width: 100%;
            background-color: rgba(225, 225, 225, 1);
        }
        .box-login{
            box-shadow: 3px 3px 3px #888;
            box-shadow: 10px 10px 5px rgb(200, 200, 200);
            max-width: 600px;
            width: 95%;
            padding: 60px 2%;
            background: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            -ms-transform: translate(-50%, -50%);
        }
        .box-login h2 {
            text-align: center;
            font-size: 1.5em;
            color: black;
        }
        .box-login input{
            width:  100%;
            height: 40px;
            border: 1px solid #ccc;
            padding-left: 8px;
            margin-bottom: 8px;
        }
        .box-login input[type=text],
        .box-login input[type=password]{
            
        }
        .box-login input[type=submit]{
            color: white;
            background-color: #00BFA5;
            font-size: 1em;
            font-weight: bold;
            border: 0;
            cursor: pointer;
            width: 50%;
        }
        .box-login form labels {

        }
        .red-box {
            text-align: center;
            color: white;
            background: #F75353;
            font-size: 1em;
            width: 100%;
            padding: 0.5em 2%;
        } */
    </style>
</head>

<body>

    <?php
    // include('../config.php');
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    // $pdo = Sql::connectar();


    ?>
    <div class="box-login">
        <a href="../">Voltar</a>
        <h2>Area de login</h2>

        <form method="post" action="">
            <label for="username">Username: </label>
            <input type="text" name="username" id="username" value="<?php echo $_COOKIE['user'] ?: '' ?>" placeholder="Username">
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" value="<?php echo $_COOKIE['pass']?: '' ?>" placeholder="Password">

            <input type="submit" name="login" value="Login">
            <div class="w-50" style="display: inline-block; float: right;">
                <label for="remindMe">Remember ?</label>
                <input type="checkbox" name="remindMe" id="remindMe" value="bla" style="height: 1em; width: 1em;" <?php echo ($_COOKIE['remember'] == 0) ?: 'checked';?>>
            </div>
        </form>
    </div>




</body>

</html>