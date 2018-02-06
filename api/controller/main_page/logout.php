<?php

session_destroy();

$response = new stdClass();
$response->message = 'You have logged out';
echo json_encode($response);