<?php
header("Content-Type: application/json; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/ReservationService.php';

$roomNumber = $_GET['room'];
$reservationService = new ReservationService();

echo $reservationService->reserve($roomNumber);
