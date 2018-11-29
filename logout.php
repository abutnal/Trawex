<?php
session_start();
session_destroy($_SEESION['user_id']);
session_unset($_SEESION['user_id']);
header("Location:index.php");
die();
?>