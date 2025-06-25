<?php
// 1. Start the session to access it.
session_start();

// 2. Unset all session variables.
$_SESSION = [];

// 3. Destroy the session itself.
session_destroy();

// 4. Redirect the user to the login page.
header("Location: index.php");
exit(); // IMPORTANT: Stop the script from executing further.
?>