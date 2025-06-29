<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST['username']) && 
        isset($_POST['email']) && 
        isset($_POST['password']) && 
        isset($_POST['confirm_password'])
    ) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (strlen($password) == 6) {
            if ($password === $confirm_password) {
                $signup = User::signup($username, $email, $password);
            } else {
                echo "<script>alert('Wrong confirm password');</script>";
                header("Location: signup.php");
                exit();
            }
        } else {
            echo "<script>alert('Password must be exactly 6 characters long');</script>";
            header("Location: signup.php");
            exit();
        }

        if ($signup) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit();
        } else {
            header("Location: signup.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sign Up </title>
	<link rel="stylesheet" href="assests/css/authenticate.css">
</head>

<body>
	<div class="container">
		<form class="signup-form" method="POST">
			<h2>Create Account</h2>

			<input type="text" name="username" placeholder="Username" required>
			<input type="email" name="email" placeholder="Email Address" required>
			<input type="password" name="password" placeholder="Password" required>
			<input type="password" name="confirm_password" placeholder="Confirm Password" required>

			<button type="submit">Sign Up</button>
			<p>Already have an account? <a href="login.php">Login here</a></p>
		</form>
	</div>
</body>

</html>