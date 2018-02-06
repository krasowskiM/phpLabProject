<?php

include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/db/DbConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/dto/ApiError.php';
session_start();

class ReservationService {

    function reserve($roomNumber, $dateOfRent) {
        $pdo = DBConnection::getInstance()->getConnection();
        $pdo->beginTransaction();
        $userId = $this->getUserIdBySession($pdo);
        $roomId = $this->getRoomIdByNumber($pdo, $roomNumber);
        $execute = $this->performReservation($pdo, $userId, $roomId, $dateOfRent);
        if ($execute) {
            $pdo->commit();
            $response = new stdClass();
            $response->message = 'OK';
            return json_encode($response);
        } else {
            $pdo->rollback();
            $apiError = new ApiError();
            $apiError->message = 'Reservation failed. Please contact our staff.';
            return json_encode($apiError);
        }
    }

    function performReservation($pdo, $userId, $roomId, $dateOfRent) {
        $sql = "INSERT INTO reservations(status, user_id, room_id, date_of_rent) "
                . "VALUES ('PENDING', :userId, :roomId, :dateOfRent)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':roomId', $roomId);
        $statement->bindParam(':dateOfRent', $dateOfRent);
        return $statement->execute();
    }

    function getUserIdBySession($pdo) {
        $email = $_SESSION['user'];
        $selectUserId = "SELECT id FROM users WHERE email = :email";
        $selectUserStmt = $pdo->prepare($selectUserId);
        $selectUserStmt->bindParam(':email', $email);
        $selectUserStmt->execute();
        $user = $selectUserStmt->fetch(PDO::FETCH_ASSOC);
        return $user['id'];
    }

    function getRoomIdByNumber($pdo, $roomNumber) {
        $selectRoomId = "SELECT id FROM rooms WHERE room_number = :roomNumber";
        $selectRoomStmt = $pdo->prepare($selectRoomId);
        $selectRoomStmt->bindParam(':roomNumber', $roomNumber);
        $selectRoomStmt->execute();
        $room = $selectRoomStmt->fetch(PDO::FETCH_ASSOC);
        return $room['id'];
    }

    function cancel($reservationId) {
        $sql = "UPDATE reservations SET status = 'CANCELED' WHERE id = :reservationId";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':reservationId', $reservationId);
        $execute = $statement->execute();
        if ($execute) {
            $response = new stdClass();
            $response->message = 'OK';
            return json_encode($response);
        } else {
            $apiError = new ApiError();
            $apiError->message = 'Cancellation failed. Please contact our staff.';
            return json_encode($apiError);
        }
    }

    function getReservations($userId) {
        $sql = "SELECT * FROM reservations WHERE user_id = :userId";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $execute = $statement->execute();
        if ($execute) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

}
