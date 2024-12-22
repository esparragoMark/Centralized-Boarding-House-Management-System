<?php
session_start();
require "config/config.php";

$token = $_POST['token'];
$userRole = $_POST['userRole'];
$password = $_POST['password'];
$pass_confirm = $_POST['pass_confirm'];

// Generate a hash of the token for secure comparison
$token_hash = hash("sha256", $token);

// Corrected SQL query syntax based on user role
if ($userRole === 'student') {
    $sql = "SELECT * FROM users WHERE reset_token = '$token_hash'";
} elseif ($userRole === 'landlord') {
    $sql = "SELECT * FROM landlords_acc WHERE reset_token = '$token_hash'";
} elseif ($userRole === 'admin') {
    $sql = "SELECT * FROM admin_acc WHERE reset_token = '$token_hash'";
} else {
    $_SESSION['message'] = "Invalid user role.";
    $_SESSION['message_type'] = "danger";
    header('Location: reset_password.php');
    exit();
}

$sql_run = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($sql_run);

// Check if the token exists in the database
if ($user === null) {
    die("Token not found");
}

// Check if the reset token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

// Check if the password fields match
if ($password !== $pass_confirm) {
    $_SESSION['message'] = "Passwords must match";
    $_SESSION['message_type'] = "warning";
    header("Location: reset_password.php?token=$token&userRole=$userRole");
    exit();
}

// Get the appropriate user ID based on user role
if ($userRole === 'student') {
    $userID = $user['user_id'];
} elseif ($userRole === 'landlord') {
    $userID = $user['landlord_id'];
} elseif ($userRole === 'admin') {
    $userID = $user['id'];
}

// Hash the new password securely
$new_password_hash = password_hash($password, PASSWORD_DEFAULT);

// SQL query to update the password and reset token fields
if ($userRole === 'student') {
    $reset_sql = "UPDATE users SET password = '$new_password_hash',
                    reset_token = NULL,
                    reset_token_expires_at = NULL
                    WHERE user_id = '$userID'";
} elseif ($userRole === 'landlord') {
    $reset_sql = "UPDATE landlords_acc SET password = '$new_password_hash',
                    reset_token = NULL,
                    reset_token_expires_at = NULL
                    WHERE landlord_id = '$userID'";
} elseif ($userRole === 'admin') {
    $reset_sql = "UPDATE admin_acc SET password = '$new_password_hash',
                    reset_token = NULL,
                    reset_token_expires_at = NULL
                    WHERE id = '$userID'";
}

$reset_sql_run = mysqli_query($con, $reset_sql);

// Check if the update was successful
if ($reset_sql_run) {
    $_SESSION['message'] = "Password successfully reset.";
    $_SESSION['message_type'] = "success";
    header('Location: login.php');
    exit();
} else {
    // Error handling if the update fails
    $_SESSION['message'] = "Error resetting password. Please try again.";
    $_SESSION['message_type'] = "danger";
    header('Location: reset_password.php');
    exit();
}
?>
