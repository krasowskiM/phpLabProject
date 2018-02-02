<?php
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/db/DbConnection.php';

class ReservationService {

    function reserve($userId, $roomId, $dateOfRent) {
        $sql = "INSERT INTO reservations(status, user_id, room_id, date_of_rent) "
                . "VALUES ('PENDING', :userId, :roomId, :dateOfRent)";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->bindParam(array(':userId' => $userId, ':roomId' => $roomId, ':dateOfRent' => $dateOfRent));
        $execute = $statement->execute();
        if ($execute) {
            $response = new stdClass();
            $response->message = 'OK';
            return json_encode($response);
        } else {
            $apiError = new ApiError();
            $apiError->message = 'Reservation failed. Please contact our staff.';
            return json_encode($apiError);
        }
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
    
    function getReservations($userId){
        $sql = "SELECT * FROM reservations WHERE user_id = :userId";
    }

}
