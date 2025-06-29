<?php
include "libs/include/Database.class.php";
include "libs/include/User.class.php";

$json_data = file_get_contents('php://input');
$data = json_decode($json_data,true);
header('Content-Type: application/json');

$user = $data['user'];
$videoid = $data['videoid'];
$status = $data['status'];


if($status=="liked")
{
   if(User::likes($user,$videoid))
   {
     echo json_encode(["status"=>"success","action"=>"liked"]);
   }
   else{
     echo json_encode(["status"=>"failed","action"=>"none"]);
   }
}


echo json_encode(["status" => "error", "action" => "invalid"]);
exit;

