<?php
header("Content-Type: application/json; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/RoomService.php';

$floorNumber = $_GET['number'];
$roomService = new RoomService();

echo $roomService->getFloor($floorNumber);