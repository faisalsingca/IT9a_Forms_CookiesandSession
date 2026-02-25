<?php
// Start session
session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Clear cookies by setting them to expire in the past
if (isset($_COOKIE['remembered_user'])) {
    setcookie('remembered_user', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_preference'])) {
    setcookie('user_preference', '', time() - 3600, '/');
}
if (isset($_COOKIE['last_login'])) {
    setcookie('last_login', '', time() - 3600, '/');
}

// Set a logout cookie (optional - just to show cookie can be set)
setcookie('logout_message', 'You have been logged out', time() + 30, '/');

// Redirect to login with GET parameter
header('Location: login.php?message=Successfully%20logged%20out');
exit();
?>