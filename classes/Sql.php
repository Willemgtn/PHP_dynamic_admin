<?php 
    class Sql  
    {
        static $pdo;

        static function connect(){
            if(self::$pdo == null){
               // self::$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DBNAME,DB_USER,DB_PASS);
                // self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                try{
                    self::$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DBNAME,DB_USER,DB_PASS, array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_PERSISTENT => true
                    ));
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e){
                    echo 'erro ao conectar ao DB';
                }                
            } 
            return self::$pdo;
        }
    }
