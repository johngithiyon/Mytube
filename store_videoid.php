<?php
session_start();
$json_data = file_get_contents("php://input");

$data = json_decode($json_data,true);

if (isset($data['videoid'])) {
    $_SESSION['videoid'] = $data['videoid'];
    echo json_encode(["status" => "stored"]);
} else {
    echo json_encode(["status" => "failed", "reason" => "no videoid"]);
}