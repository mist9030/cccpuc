<?php
session_start();
session_destroy();
header("Location: /PUC/index2.php");
exit;
?>