<?php
// start the session to access it.
session_start();

// unset all session variables.
$_SESSION = [];

// destroy the session itself.
session_destroy();

// redirect the user to the login page.
header("Location: index.php");
exit();
?>