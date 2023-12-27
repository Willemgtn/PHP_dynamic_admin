<?php 
    class Sql  
    {
      public $error = "";
      private $pdo = null;
      private $stmt = null;
        static $s_pdo;

        static function connect(){
            if(self::$s_pdo == null){
               // self::$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DBNAME,DB_USER,DB_PASS);
                // self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                try{
                    self::$s_pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_DBNAME,DB_USER,DB_PASS, array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_PERSISTENT => true,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ));
                    // self::$s_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $e){
                    echo 'erro ao conectar ao DB';
                }                
            } 
            return self::$s_pdo;
        }
        // (A) CONNECT TO DATABASE
        function __construct () {
          $this->pdo = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_DBNAME.";charset=".'utf8', 
            DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
          ]);
        }
      
        // (B) CLOSE CONNECTION
        function __destruct () {
          if ($this->stmt!==null) { $this->stmt = null; }
          if ($this->pdo!==null) { $this->pdo = null; }
        }
      
        // (C) RUN A SELECT QUERY
        function select ($sql, $data=null) {
          $this->stmt = $this->pdo->prepare($sql);
          $this->stmt->execute($data);
          return $this->stmt->fetchAll();
        }

    }
