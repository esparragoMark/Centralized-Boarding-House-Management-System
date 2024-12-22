<?php
session_start();
require "config/config.php";

$userRole = $_POST['userRole'];
$email = $_POST['emailAddress'];

// Check if the email exists in the specified table based on user role
if ($userRole === 'student') {
    $email_check_sql = "SELECT * FROM users WHERE email = '$email'";
    $email_check_run = mysqli_query($con, $email_check_sql);
    $table = "users";
} elseif ($userRole === 'landlord') {
    $email_check_sql = "SELECT * FROM landlords_acc WHERE email = '$email'";
    $email_check_run = mysqli_query($con, $email_check_sql);
    $table = "landlords_acc";
} elseif ($userRole === 'admin') {
    $email_check_sql = "SELECT * FROM admin_acc WHERE email = '$email'";
    $email_check_run = mysqli_query($con, $email_check_sql);
    $table = "admin_acc";
} else {
    $_SESSION['message'] = "Invalid user role.";
    $_SESSION['message_type'] = "danger";
    header('Location: forget_password.php');
    exit();
}

// Check if the email exists in the chosen table
if (mysqli_num_rows($email_check_run) == 0) {
    $_SESSION['message'] = "Email does not exist.";
    $_SESSION['message_type'] = "warning";
    header('Location: forget_password.php');
    exit();
}

// Generate a secure token and hash it
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 minutes from now

// Update the record with the token and expiry time in the correct table
$sql = "UPDATE $table
        SET reset_token = '$token_hash',
            reset_token_expires_at = '$expiry'
        WHERE email = '$email'";
$sql_run = mysqli_query($con, $sql);

if ($sql_run) {
    // Load the mailer configuration
    $mail = require __DIR__ . "/mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";


    // construct the reset link
    $mail->Body = <<<END
    Click <a href="http://debes.kesug.com/reset_password.php?token=$token&userRole=$userRole">here</a>
    to reset your password.
    END;
    

    // ==============================================================================================================
    // RUN THESE LINE OF CODES IF YOU ARE TRYING TO RUN IN LOCALHOST
    // $mail->Body = <<<END
    // Click <a href="http://localhost/HausMasterSystem/reset_password.php?token=$token&userRole=$userRole">here</a>
    // to reset your password.
    // END;
    // ==============================================================================================================

    try {
        $mail->send();
        $_SESSION['message'] = "Message sent. Please check your inbox.";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        $_SESSION['message'] = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "Failed to initiate password reset. Please try again.";
    $_SESSION['message_type'] = "danger";
}

// Redirect back to the forget password page
header('Location: forget_password.php');
exit();
?>
