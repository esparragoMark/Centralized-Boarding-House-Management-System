<?php
session_start();
include("../../config/config.php");

if (isset($_POST['btn-addAccount'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $bhname = mysqli_real_escape_string($con, $_POST['bhname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO landlords_acc (fullname, bh_name, email, password) VALUES ('$name', '$bhname', '$email', '$hashedPassword')";
    $sql_run = mysqli_query($con, $sql);

    if ($sql_run) {
        $_SESSION['message'] = "Save";
        $_SESSION['message_type'] = "success";
        header("Location: account.php");
    } else {
        $_SESSION['message'] = "Something Went Wrong!";
        $_SESSION['message_type'] = "warning";
        header("Location: account.php");
    }
}
?>
