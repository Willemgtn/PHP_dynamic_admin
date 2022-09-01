<?php 

    class ViewMetrics{
        static function updateOnlineUser(){
            if(isset($_SESSION['online'])){
                $token = $_SESSION['online'];
                $actualTime = date('Y-m-d H:i:s');
                $sql = Sql::connect() -> prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
                $sql -> execute(array($actualTime, $token));
            } else {
                $_SESSION['online'] = uniqid();
                $ip = $_SERVER['REMOTE_ADDR'];
                $token = $_SESSION['online'];
                $actualTime = date('Y-m-d H:i:s');
                $sql = Sql::connect() -> prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
                $sql -> execute(array($ip, $actualTime, $token));
            }
        }
        static function incrementUserView(){
            // use SQL subquery to update count based on selected count + 1
            if(isset($_SESSION['online'])){
                $token = $_SESSION['online'];
                $actualTime = date('Y-m-d H:i:s');
                $sql = Sql::connect() -> prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
                $sql -> execute(array($actualTime, $token));
            } else {
                $_SESSION['online'] = uniqid();
                $ip = $_SERVER['REMOTE_ADDR'];
                $token = $_SESSION['online'];
                $actualTime = date('Y-m-d H:i:s');
                $sql = Sql::connect() -> prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
                $sql -> execute(array($ip, $actualTime, $token));
            }
        }
        static function cookieCounter(){
            // setCookie('visita', 'true', time() - 1);
            if(!isset($_COOKIE['visita'])){
                setCookie('visita', 'true', time() + (60*60*24));
                $sql = Sql::connect() -> prepare("INSERT INTO `tb_admin.visits` VALUES (null,?,?)");
                // print_r(array($_SERVER['REMOTE_ADDR'], date('Y-m-d')));
                $sql -> execute(array($_SERVER['REMOTE_ADDR'], date('Y-m-d')));
            }
        }
    }
?>