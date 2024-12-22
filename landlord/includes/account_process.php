<?php
session_start();
include('../../config/config.php');
include('../../functionCode/function.php');
include('../../middleware/middleware.php');

// Get landlord ID from session
$landlord_id = $_SESSION['auth_landlord']['id'];

if (isset($_POST['submit_editProfile'])) {
    // Fetch current landlord data
    $current_data = "SELECT * FROM landlords_acc WHERE landlord_id = '$landlord_id'";
    $current_data_run = mysqli_query($con, $current_data);

    if (mysqli_num_rows($current_data_run) > 0) {
        $result = mysqli_fetch_assoc($current_data_run);
        
        $current_fullname = $result['fullname'];
        $current_bhName = $result['bh_name'];
        $current_email = $result['email'];
        $current_password = $result['password'];
    } else {
        echo "No data found!";
    }

    // Retrieve input values
    $fullname = !empty($_POST['fullname']) ? trim($_POST['fullname']) : $current_fullname;
    $bhName = !empty($_POST['bhName']) ? $con->real_escape_string(trim($_POST['bhName'])) : $current_bhName;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : $current_email;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : $current_password;

    // Email existence check
    if ($email != $current_email) {
        $email_check = "SELECT email FROM landlords_acc WHERE email = '$email'";
        $email_check_run = mysqli_query($con, $email_check);

        if (mysqli_num_rows($email_check_run) > 0) {
            $_SESSION['message'] = "Email Already Exists. Please Try Again!";
            $_SESSION['message_type'] = "warning";
            header('Location: account.php');
            exit;
        }
    }

    // Hash the new password if it's not empty and different from the current password
    if (!empty($password) && $password !== $current_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $current_password; // Keep the old password
    }

    // Update landlord account
    $sql_update = "UPDATE landlords_acc SET fullname = '$fullname', bh_name = '$bhName', 
                   email = '$email', password = '$hashed_password' WHERE landlord_id = '$landlord_id'";

    $sql_update_run = mysqli_query($con, $sql_update);

    if ($sql_update_run) {
        $_SESSION['message'] = "Successfully Updated";
        $_SESSION['message_type'] = "success";
        header('Location: account.php');
    } else {
        $_SESSION['message'] = "Failed To Update!";
        $_SESSION['message_type'] = "warning";
        header('Location: account.php');
    }
}
if (isset($_POST['submit_imageUpload'])) {
    if (!empty($_FILES['profileImage']['name'])) {
        // Upload new image
        $uploadDir = "../landlord_uploads/";
        $profile_image = uploadFile('profileImage', $uploadDir);

        // Fetch current profile image
        $current_profile = "SELECT image FROM profile_image WHERE landlord_id = '$landlord_id'";
        $current_profile_run = mysqli_query($con, $current_profile);
        
        if (mysqli_num_rows($current_profile_run) > 0) {
            $result_image = mysqli_fetch_assoc($current_profile_run);   
            $currentProfile = $result_image['image'];

            if ($profile_image) {
                if (!empty($currentProfile) && file_exists($uploadDir . $currentProfile)) {
                    unlink($uploadDir . $currentProfile); // Delete old image
                }
            }

            // Update existing image
            $update_image_query = "UPDATE profile_image SET image = '$profile_image' WHERE landlord_id = '$landlord_id'";
            $update_image_query_run = mysqli_query($con, $update_image_query);

            if (!$update_image_query_run) {
                $_SESSION['message'] = "Failed to update profile image!";
                $_SESSION['message_type'] = "warning";
                header('Location: account.php');
                exit;
            }
        } else {
            // Insert new image
            $addProfile = "INSERT INTO profile_image(image, landlord_id) VALUES('$profile_image', '$landlord_id')";
            mysqli_query($con, $addProfile);
        }
    }

    $_SESSION['message'] = "Profile image updated successfully!";
    $_SESSION['message_type'] = "success";
    header('Location: account.php');
}

$con->close();
?>
