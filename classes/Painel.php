<?php
// include('../config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



class Painel
{
    static function logado()
    {
        return isset($_SESSION['login']) ? true : false;
    }
    static function logout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['user']);
        unset($_SESSION['pass']);
        
        session_destroy();
        // setcookie("remember", true, time()-1, '/');
        header('Location: ./');
        die();
    }
    static function loadPage()
    {
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url']);
            if (file_exists('pages/' . $url[0] . '.php')) {
                include('pages/' . $url[0] . '.php');
            } else {
                // include('pages/home.php');
                header('Location: ./');
            }
        }
    }
    static function loadJS(array $files, $page, $painel = false)
    {
      $includePath = INCLUDE_PATH;
      $includePath .= $painel ? 'painel/js' : 'js';
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url'])[0];
            if ($page == $url) {
                foreach ($files as $key => $value) {
                    echo "<script src='$includePath/$value'></script>";
                }
            }
        }
        if ($page == '*') {
          foreach ($files as $key => $value) {
              echo "<script src='$includePath/$value'></script>";
          }
      }
    }
    static function loadCss(array $files, $page='*', $painel = false)
    {
      $includePath = INCLUDE_PATH;
      $includePath .= $painel ? 'painel/css' : 'css';
        if (isset($_GET['url'])) {
            $url = explode('/', $_GET['url'])[0];
            if ($page == $url) {
                foreach ($files as $key => $value) {
                    echo "<script src='$includePath/$value'></script>";
                }
            } 
        } 
        if ($page == '*'){
          foreach ($files as $key => $value) {
            echo "<link rel=\"stylesheet\" href='$includePath/$value'>";
        }
        }
    }
    static function listOnlineUsers()
    {
        // self::cleanOnlineUsers();
        // $sql = Sql::connect() -> prepare("SELECT * FROM `tb_admin.online`");
        $date = date('Y-m-d H:i:s');
        $sql = Sql::connect()->prepare("SELECT * FROM `tb_admin.online` WHERE ultima_acao > '$date' - INTERVAL 1 MINUTE");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    static function cleanOnlineUsers()
    {
        $date = date('Y-m-d H:i:s');
        Sql::connect()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
    }
    static function totalVisits()
    {
        $sql = Sql::connect()->prepare("SELECT * FROM `tb_admin.visits`");
        $sql->execute();
        return $sql->rowCount();
    }
    static function todaysVisits()
    {
        $date = date('Y-m-d');
        $sql = Sql::connect()->prepare("SELECT * FROM `tb_admin.visits` WHERE day = '$date' ");
        $sql->execute();
        return $sql->rowCount();
    }
    static function htmlPopUp($htmlClass, $msg)
    {
        switch ($htmlClass) {
            case 'ok':
                $icon = '<i class="fa-solid fa-check"></i> ';
                break;
            case 'error':
                $icon = '<i class="fa-solid fa-xmark"></i> ';
                break;
            case 'warn':
                $icon = '<i class="fa-solid fa-triangle-exclamation"></i> ';
                break;

            default:
                $icon = '';
                break;
        }
        echo '<div class="box-alert ' . $htmlClass . '">' . $icon . $msg . '</div>';
    }
    static function redirect($url)
    {
        echo '<script>location.href="' . $url . '"</script>';
    }
}
