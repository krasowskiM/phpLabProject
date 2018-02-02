<?php

header("Content-Type: application/json; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/userService.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/dto/ApiError.php';


$data = json_decode(file_get_contents("php://input"));
if ($data == null) {
    $apiError = new ApiError();
    $apiError->message = "Empty credentials provided!";
    echo json_encode($apiError);
} else {
    $email = $data->email;
    $password = $data->password;
    $userService = new UserService();

    echo $userService->login($email, $password);
}