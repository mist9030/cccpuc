<?php
session_start();
if (isset($_SESSION['roll'])) {
    header("Location:homepage.php");
    exit();
}
include("connection.php");
if(isset($_POST['login']))
{
	$roll=$_POST['roll'];
	$password=$_POST['password'];

	$sql="select roll,password from users where roll='$roll' and password='$password'";
            $user=mysqli_query($con,$sql);
            if(mysqli_num_rows($user)==1)
            {
                $_SESSION['roll']=$roll;
                header("Location:homepage.php");
            }
            else
            {
                echo "<p style='color: red;'>Incorrect UserId or Password</p>";
            }
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CCCPUC</title>
    <link rel="stylesheet" href="./CSS/login.css">
    <link rel="stylesheet" href="./CSS/index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <section class="login-container">
            <h1>User Login</h1>
            <form action="login.php" method="POST" class="login-form">
                <label for="roll">Student ID:</label>
                <input type="number" id="roll" name="roll" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php" class="btn-link">Register</a></p>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>