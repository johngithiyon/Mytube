<?php

include_once "Database.class.php";

class User
{
    public static function signup($username, $email, $password)
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $password);
        if ($stmt->execute()) {
            return true ;
        } else {
            return false;
        }
    }

    public static function login($email, $password)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

    }

    public static function videos_info($title, $description, $video_url)
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO videos (title, description,video_url) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $title, $description, $video_url);
        $result = $stmt->execute();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public static function fetch_video_info()
    {
        $conn = Database::getConnection();
        $sql = "SELECT id,title,description,video_url  FROM videos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $videos[] = $row;

            }

            return $videos;

        }
    }


    public static function likes($user, $videoid)
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO likes (username, video_id, liked_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $user, $videoid);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }


    public static function count_likes($videoid)
    {
        $conn = Database::getConnection();
        $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE video_id = ?";
        $stmt =  $conn->prepare($sql);
        $stmt->bind_param('i', $videoid);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['like_count'];
        } else {
            return false;
        }
    }


    public static function unlike($user,$videoid)
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO unlikes (user, videoid,created_at) VALUES (?,?,Now());";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si',$user,$videoid);
        if($stmt->execute())
        {
            return true;
        }
        else{
            return false;
        }
        
    }

    public static function comment($user,$videoid,$comment)
    {
        $conn = Database::getConnection();
        $sql = "INSERT INTO comments (user, videoid, comment,created_at) VALUES (?, ?, ?,Now());";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss',$user,$videoid,$comment);
        if($stmt->execute())
        {
            return true;
        }
        else{
            return false;
        }
    }

    public static function fetch_comment($videoid)
    {
        $conn = Database::getConnection();
        $sql = "SELECT user, comment, created_at FROM comments WHERE videoid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s',$videoid);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0)
        {
            while($row=$result->fetch_assoc())
            {
                $comment_data [] = $row;
            }
            return $comment_data;
        }
        else{
            return false;
        }

    }
}
