<?php
include_once "include/User.class.php";
include_once "include/Database.class.php";

function load_template($name)
{
    include $_SERVER['DOCUMENT_ROOT']."/mytube/_templates/$name.php";
}

