<?php

session_start();
include('../config/config.php');

// FOR REGISTRATION FORM
if (isset($_POST['register_btn'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $contactNumber = mysqli_real_escape_string($con, $_POST['contactNumber']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $emailAddress = mysqli_real_escape_string($con, $_POST['emailAddress']);
    $guardianName = mysqli_real_escape_string($con, $_POST['guardian']);
    $guardianContact = mysqli_real_escape_string($con, $_POST['guardianContact']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($con, $_POST['confirmPassword']);

    $check_email_query = "SELECT email FROM users WHERE email = '$emailAddress'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['message'] = "Email already Registered";
        $_SESSION['message_type'] = 'warning';
        header('Location: ../register.php');
    } else {
        if ($password == $confirmPassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data with hashed password
            $insert_query = "INSERT INTO users (fullname, gender, course, contact_number, address, guardian_name, guardian_contact, email, password)
                            VALUES ('$fullname', '$gender', '$course', '$contactNumber', '$address', '$guardianName', '$guardianContact', '$emailAddress', '$hashedPassword')";

            $insert_query_run = mysqli_query($con, $insert_query);

            if ($insert_query_run) {
                $_SESSION['message'] = "Registered Successfully";
                $_SESSION['message_type'] = 'success';
                header('Location: ../register.php');
            } else {
                $_SESSION['message'] = "Something went wrong";
                $_SESSION['message_type'] = 'warning';
                header('Location: ../register.php');
            }
        } else {
            $_SESSION['message'] = "Passwords do not match";
            $_SESSION['message_type'] = 'warning';
            header('Location: ../register.php');
        }
    }
}
// FOR LOGIN FORM
else if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['emailAddress']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query for users table
    $login_query = "SELECT * FROM users WHERE email = '$email'";
    $login_query_run = mysqli_query($con, $login_query);

    // Query for landlords table
    $landlord_query = "SELECT * FROM landlords_acc WHERE email = '$email'";
    $landlord_query_run = mysqli_query($con, $landlord_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $userdata = mysqli_fetch_array($login_query_run);
        
        // Verify password
        if (password_verify($password, $userdata['password'])) {
            $_SESSION['authentication'] = true;

            // Store user data in session
            $_SESSION['auth_user'] = [
                'name' => $userdata['fullname'],
                'gender' => $userdata['gender'],
                'course' => $userdata['course'],
                'contact_number' => $userdata['contact_number'],
                'address' => $userdata['address'],
                'guardian_name' => $userdata['guardian_name'],
                'guardian_contact' => $userdata['guardian_contact'],
                'id' => $userdata['user_id']
            ];

            $_SESSION['message'] = "Logged In Successfully";
            $_SESSION['message_type'] = 'success';
            header('Location: ../index.php'); // Redirect to user dashboard
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            $_SESSION['message_type'] = 'warning';
            header('Location: ../login.php');
        }
    } else if (mysqli_num_rows($landlord_query_run) > 0) {
        $landlorddata = mysqli_fetch_array($landlord_query_run);
        
        // Verify landlord password
        if (password_verify($password, $landlorddata['password'])) {
            $_SESSION['authentication'] = true;

            // Store landlord data in session
            $_SESSION['auth_landlord'] = [
                'fullname' => $landlorddata['fullname'],
                'email' => $landlorddata['email'],
                'bh_name' => $landlorddata['bh_name'],
                'id' => $landlorddata['landlord_id']
            ];

            $_SESSION['message'] = "Logged In Successfully";
            $_SESSION['message_type'] = 'success';
            header('Location: ../landlord/includes/index.php'); // Redirect to landlord dashboard
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            $_SESSION['message_type'] = 'warning';
            header('Location: ../login.php');
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        $_SESSION['message_type'] = 'warning';
        header('Location: ../login.php');
    }
}

?>
