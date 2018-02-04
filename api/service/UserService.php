<?php

include $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/db/DbConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/model/User.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/dto/ApiError.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/room-reservations/api/service/SecService.php';

class UserService {

    private $safeEmail;

    public function login($email, $password) {
        $userData = $this->getUserData($email);
        if ($userData == null) {
            $apiError = new ApiError();
            $apiError->message = "User not found!";
            return json_encode($apiError);
        } else {
            $loginSuccess = password_verify($password, $userData['password']);
            if ($loginSuccess) {
                $this->saveUser($userData);
                $response = new stdClass();
                $response->message = "OK";
//                w razie jakbym miał kiedyś ochotę to dorobię więcej
//                $this->saveLastLogin($this->safeEmail);
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
        $xssSafeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $xssSafePassword = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
        $pdo = DBConnection::getInstance()->getConnection();
        $query = $pdo->prepare($registerQuery);
        $execute = $query->execute(array(
            ":email" => $xssSafeEmail,
            ":password" => password_hash($xssSafePassword, PASSWORD_BCRYPT)
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
        $xssSafeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $this->safeEmail = $xssSafeEmail;
        $pdo = DBConnection::getInstance()->getConnection();
        $statement = $pdo->prepare($loginQuery);
        $statement->bindParam(':email', $xssSafeEmail, PDO::PARAM_STR);
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

    private function saveUser($userData) {
        $status = $userData['status'];
        if ($status == 'USER') {
            $encryptedMail = $this->encryptMail($this->safeEmail);
            $_SESSION['user'] = $encryptedMail;
        }
    }

    private function encryptMail($email) {
        $secData = SecService::getSecData();
        $cipher = $secData['mode'];
        $initVectorLength = openssl_cipher_iv_length($cipher);
        $initVector = openssl_random_pseudo_bytes($initVectorLength);
        $_SESSION['rand'] = $initVector;
        $key = $secData['hash'];

        return openssl_encrypt($email, $cipher, $key, 0, $initVector);
    }

    public static function decryptUser() {
        $secData = SecService::getSecData();
        $cipher = $secData['mode'];
        $key = $secData['hash'];
        $data = $_SESSION['user'];
        $initVector = $_SESSION['rand'];
        return openssl_decrypt($data, $cipher, $key, 0, $initVector);
    }

}
