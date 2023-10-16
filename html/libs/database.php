<?php

include_once '/var/www/html/config/config.php';
require_once '/var/www/html/config/config.php';

class Database{
    private $pdo;
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct(){
        $this->host = constant('HOST');
        $this->db = constant('DB');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
        $this->charset = constant('CHARSET');
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->pdo = new PDO($connection, $this->user, $this->password, $options);
            error_log('Conexión a BD exitosa');
            return $this->pdo;
        }catch(PDOException $e){
            error_log('Error connection: ' . $e->getMessage());
        }
    }
    public function getPDO() {
        return $this->pdo;
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}

?>