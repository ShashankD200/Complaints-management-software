<?php
session_start();
session_unset();
session_destroy();
header("location: ../../frontend/login.php");
exit;
?>