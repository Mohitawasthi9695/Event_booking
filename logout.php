<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Optional: remove session cookie
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect to login page or homepage
header("Location: login.php"); 
exit;
?>