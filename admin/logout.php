<?php
session_start();
session_destroy();
header("Location: /PUC/admin/login.php");
exit;
?>