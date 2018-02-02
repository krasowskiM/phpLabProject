<?php

include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/db/DbConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/model/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/dto/ApiError.php';

class UserService {

    public function login($email, $password) {
        $userData = $this->getUserData($email);
        if ($userData == null) {
            $apiError = new ApiError();
            $apiError->message = "User not found!";
            return json_encode($apiError);
        } else {
            $loginSuccess = password_verify($password, $userData['password']);
            if ($loginSuccess) {
                $response = new stdClass();
                $response->message = "OK";
//                w razie jakbym miał kiedyś ochotę to dorobię więcej
//                $this->saveLastLogin($email);
                return json_encode($response);
            } else {
                $apiError = new stdClass();
                $apiError->message = "Login failed!";
                return json_encode($apiError);
            }
        }
    }

    public function register($email, $password) {
        $registerQuery = "INSERT INTO users(email, password, status) VALUES (:email, :password, 'USER');";
        $pdo = DBConnection::getInstance()->getConnection();
        $query = $pdo->prepare($registerQuery);
        $execute = $query->execute(array(
            ":email" => $email, ":password" => password_hash($password, PASSWORD_BCRYPT)
        ));
        if ($execute) {
            $response = new stdClass();
            $response->message = 'OK';
            return json_encode($response);
        } else {
            $apiError = new ApiError();
            $apiError->message = "Registration failed! Check your credentials";
            return json_encode($apiError);
        }
    }

    private function getUserData($email) {
        $loginQuery = "SELECT email, password, status FROM users WHERE email = :email";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($loginQuery);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $execute = $statement->execute();
        if ($execute) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

    private function saveLastLogin($email) {
        $loginDate = date();
        $sql = "UPDATE user SET last_login_date = :loginDate WHERE email = :email";
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($sql);
        $statement->bindParam('loginDate', $loginDate);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->execute();
    }

}
