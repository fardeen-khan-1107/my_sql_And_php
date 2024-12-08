<?php
session_start();

// Check if the user is logged in and has a valid session
if (!isset($_SESSION['fullname'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Check the role of the user (optional, based on your needs)
if ($_SESSION['role'] == 'admin') {
    header("Location: view_admin.php");
} elseif ($_SESSION['role'] == 'user') {
    header("Location: view_product.php");
} else {
    // If the role is not set properly or is invalid, log the user out or redirect them
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
