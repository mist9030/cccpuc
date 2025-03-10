<?php
session_start();
include_once('../connection.php');
$roll = $_SESSION['roll'];

if (!isset($_SESSION['roll'])) {
    header("Location: ../login.php");
    exit();
}

$query = "SELECT * FROM users WHERE roll='$roll'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result)==0) {
    echo "User not found!";
    header("Location: logout.php");
    exit();
}
?>