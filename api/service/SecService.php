<?php

class SecService {
    
    public static function getSecData(){
        $sql = "SELECT * FROM sec";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
