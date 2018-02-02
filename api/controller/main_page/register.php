<?php

header("Content-Type: application/json; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/userService.php';

$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$password = $data->password;
$passwordRetype = $data->passwordRetype;
if ($password != $passwordRetype) {
    $apiError = new ApiError();
    $apiError->message = "Passwords don't match";
    echo json_encode($apiError);
} else {
    $userService = new UserService();
    $registrationStatus = $userService->register($email, $password);

    echo $registrationStatus;
}