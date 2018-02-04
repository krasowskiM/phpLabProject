<?php

header("Content-Type: application/json; charset=UTF-8");
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/userService.php';
session_start();

$userPanelTO = new stdClass();
$userPanelTO->lastLoginDate = date('d-M-y h:m:s');
$decryptedUser = UserService::decryptUser();
$userPanelTO->user = $decryptedUser;
echo json_encode($userPanelTO);
