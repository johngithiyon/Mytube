<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];

$_SESSION['remote'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];

$login = User::login($email,$password);
if($login){
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['user'] = $username;
    header("Location: index.php");
    exit();
  }
else{
   header("Location:login.php");
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="assests/css/authenticate.css">
</head>
<body>
  <div class="container">
    <form class="signup-form" method="POST">
      <h2>Welcome Back</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
