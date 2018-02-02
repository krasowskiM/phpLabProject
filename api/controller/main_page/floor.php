<?php
header("Content-Type: application/json; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/roomService.php';

$floorNumber = $_GET['number'];
$roomService = new roomService();
$rooms = $roomService->getFloor($floorNumber);

echo $rooms;