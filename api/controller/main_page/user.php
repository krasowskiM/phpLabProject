<?php
header("Content-Type: application/json; charset=UTF-8");
$userPanelTO = new stdClass();
$userPanelTO->lastLoginDate = date('d-M-y h:m:s');
echo json_encode($userPanelTO);
