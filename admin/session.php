<?php
session_start();
include_once('../connection.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION['email'];

$query = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result)==0) {
    echo "User not found!";
    header("Location: logout.php");
    exit();
}
?>