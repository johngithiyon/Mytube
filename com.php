<?php
session_start();
include "libs/include/User.class.php";

$json_data = file_get_contents("php://input");

$data = json_decode($json_data,true);

$user = $data['user'];
$videoid = $_SESSION['videoid'];
$comment = $data['comment'];

if(User::comment($user,$videoid,$comment))
{
    echo json_encode(["status"=>"success"]);
}
else{
    echo json_encode(["status"=>"failed"]);
}