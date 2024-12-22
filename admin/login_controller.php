<?php
session_start();
include("../config/config.php");

if (isset($_POST['admin_login'])) {
    $email = mysqli_real_escape_string($con, $_POST['emailAddress']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query to select the admin by email
    $login_query = "SELECT * FROM admin_acc WHERE email = '$email'";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $admin_data = mysqli_fetch_array($login_query_run);

        // Verify the password
        if (password_verify($password, $admin_data['password'])) {
            $_SESSION['admin_authentication'] = true;

            $adminName = $admin_data['fullname'];
            $profile = $admin_data['profile'];

            $_SESSION['admin_data'] = [
                'name' => $adminName,
                'email' => $email,
                'profile' => $profile
            ];

            $_SESSION['message'] = "Logged In Successfully";
            $_SESSION['message_type'] = 'success';
            header('Location: includes/index.php');
            exit; // Always exit after header redirect
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            $_SESSION['message_type'] = 'warning';
            header('Location: admin_login_form.php');
            exit; // Always exit after header redirect
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        $_SESSION['message_type'] = 'warning';
        header('Location: admin_login_form.php');
        exit; // Always exit after header redirect
    }
}
?>
