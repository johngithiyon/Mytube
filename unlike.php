<?php
include "libs/include/Database.class.php";
include 'libs/include/User.class.php';

header('Content-Type: application/json');

$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

$user = $data['user'];
$videoid = $data['videoid'];
$status = $data['status'];

if ($status === "unliked") {
    if (User::unlike($user, $videoid)) {
        echo json_encode(["status" => "success", "action" => "unliked"]);
        exit;
    } else {
        echo json_encode(["status" => "failed", "action" => "none"]);
        exit;
    }
}

// If status is not "unliked" or missing
echo json_encode(["status" => "error", "action" => "invalid"]);
exit;
