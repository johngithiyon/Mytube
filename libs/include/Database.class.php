<?php

class Database
{
    

    public static function getConnection()
    {
        $servername = "127.0.0.1";
        $port = 3307;
        $username = "root";
        $password = "john";
        $databasename = "mytube";
        

        $conn = new mysqli($servername, $username, $password,$databasename,$port);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    
}

