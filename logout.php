<?php
session_start();

// Check if session exists and is active
if (session_status() === PHP_SESSION_ACTIVE) {
  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();
}

// Redirect to login page
header('Location: login.php');
exit();
