<?php
ob_start();
include('../config.php');

ViewMetrics::updateOnlineUser();
// ViewMetrics::cookieCounter();

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    // No password encryption for simplicity's sake
    $sql = Sql::connect()->prepare('SELECT * FROM `tb_admin.users` WHERE user = ? AND password = ?');
    $sql->execute(array($user, $pass));
    if ($sql->rowCount() == 1) {
        $info = $sql->fetch();
        // sucessful login
        $online = $_SESSION['online'];
        $_SESSION = $info;
        $_SESSION['login'] = true;
        $_SESSION['online'] = $online;
        // $_SESSION['user'] = $user;
        // $_SESSION['pass'] = $pass;
        // $_SESSION['avatar'] = $info['avatar'];
        // $_SESSION['name'] = $info['name'];
        // $_SESSION['role'] = $info['role'];
        if (isset($_POST['remindMe'])) {
            setcookie('remember', true, time() + (60 * 60 * 24), '/');
            setcookie('user', $user, time() + (60 + 60 + 24), '/');
            setcookie('pass', $pass, time() + (60 + 60 + 24), '/');
        }
        header('Location: ./');
        echo '<script>window.location.replace("./"); </script>';
        die();
    } else {
        // unsucessful login
        echo '<div class="red-box"><i class="fa-solid fa-circle-exclamation"> </i> User or password mismatched</div>';
    }
}

if (Painel::logado() == false) {
    include('login.php');
} else {
    include('main.php');
}


ob_end_flush();
?>
<?php

?>