<?php
const SECRET = 'secret-key';

final class DBConnection {
    private static $instance;
    private $pdo;

    private function __construct() {
        try {
            $database = new PDO("mysql:host=localhost;dbname=hotel_db;port=3306", "hotel", "hotel");
            $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getmessage();
            die();
        }
        $this->pdo = $database;
    }
    
    public static function getInstance() {
        static $instance = null;
        if (self::$instance === NULL) {
            $instance = new DBConnection();
        }
        return $instance;
    }
    
    function getConnection(){
        return $this->pdo;
    }
}
