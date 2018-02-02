<?php

include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/db/DbConnection.php';
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/model/Room.php';

class roomService {

    public function getFloor($floorNumber) {
        $roomQuery = "SELECT * FROM rooms WHERE floor = $floorNumber";
        $pdo = DBConnection::getInstance()->getConnection();
        $query = $pdo->query($roomQuery);
        $rooms = $query->fetchAll(PDO::FETCH_CLASS, 'Room');
        
        return json_encode($rooms);
    }

}
