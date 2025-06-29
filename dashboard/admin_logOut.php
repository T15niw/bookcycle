<?php
session_start();

// unset all session variables
$_SESSION = [];

// destroy the session
session_destroy();

// redirect to logIn page
header("Location: admin_logIn.php");
exit();
?>