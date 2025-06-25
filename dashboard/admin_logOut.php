<?php
// Start the session to gain access to it
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the admin login page
header("Location: admin_logIn.php");
exit();
?>