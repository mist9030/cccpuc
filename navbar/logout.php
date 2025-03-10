<?php
session_start();
session_destroy();
header("Location: /PUC/homepage.php");
exit;
?>