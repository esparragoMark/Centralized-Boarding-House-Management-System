<?php
session_start();
include("../../config/config.php");
include("../../functionCode/function.php");

if (isset($_POST['adminUpdateAcc'])) {
    $admin_id = $_POST['admin_id'];
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Hash the password if it's provided
    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    $dir = "../assets/images/";
    
    // Check if a new file is uploaded
    if ($_FILES['profile']['error'] === UPLOAD_ERR_OK) {
        $profileName = uploadFile('profile', $dir);
    } else {
        // If no new file, fetch the existing profile name from the database
        $existing_query = "SELECT profile FROM admin_acc WHERE id = '$admin_id'";
        $existing_result = mysqli_query($con, $existing_query);
        $existing_row = mysqli_fetch_assoc($existing_result);
        $profileName = $existing_row['profile'];
    }

    // Prepare the update query
    if (!empty($password)) {
        $update_query = "UPDATE admin_acc SET fullname = '$fullname', email = '$email', password = '$hashedPassword', profile = '$profileName' WHERE id = '$admin_id'";
    } else {
        $update_query = "UPDATE admin_acc SET fullname = '$fullname', email = '$email', profile = '$profileName' WHERE id = '$admin_id'";
    }

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Account updated successfully!";
        $_SESSION['message_type'] = "success";
        header('Location: adminAccount.php'); // Redirect to account page
        exit;
    } else {
        $_SESSION['message'] = "Error updating account!";
        $_SESSION['message_type'] = "danger";
        header('Location: adminAccount.php'); // Redirect to account page
    }
}
mysqli_close($con);
?>
