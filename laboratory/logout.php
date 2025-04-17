<?php
session_start();

// Regenerate session ID to prevent fixation
session_regenerate_id(true);

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.php");
exit;
?>