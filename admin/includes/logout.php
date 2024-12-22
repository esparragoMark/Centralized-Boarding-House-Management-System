<?php
session_start();

if (isset($_SESSION['admin_authentication'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Start a new session to set the logout message
    session_start();
    $_SESSION['message'] = "Logged Out Successfully";
    $_SESSION['message_type'] = 'success';
}

header('Location: ../admin_login_form.php');
exit();
?>
