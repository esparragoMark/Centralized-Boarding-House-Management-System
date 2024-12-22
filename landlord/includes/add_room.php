<?php

session_start();
include('../../config/config.php');
include('../../functionCode/function.php');

// Get the landlord ID from the session
$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house info
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = $landlord_id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['BH-ID'] = $row['bh_id'];
} else {
    $_SESSION['message'] = 'Please Submit your Credentials';
    $_SESSION['message_type'] = 'warning';
    header('Location: credential.php');
    exit(); // Ensure no further code runs
}

// Handle form submission
if (isset($_POST['submit'])) {

    $roomName = $_POST['roomName'];
    $gender = $_POST['gender'];
    $capacity = $_POST['capacity'];
    $monthly_rent = $_POST['monthly_rent'];
    $uploadDir = '../room_bed_uploads/';
    $bh_id = $_SESSION['BH-ID'];

    // Handle multiple images
    $imagePaths = [];
    foreach ($_FILES['roomImage']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['roomImage']['error'][$key] == UPLOAD_ERR_OK) {
            // Use the modified uploadFile function with $key
            $imagePath = multiUploadFile('roomImage', $key, $uploadDir);
            if ($imagePath) {
                $imagePaths[] = $imagePath; // Store the uploaded file path
            } else {
                $_SESSION['message'] = "Failed to upload image: " . $_FILES['roomImage']['name'][$key];
                $_SESSION['message_type'] = 'warning';
                header('Location: mng_room.php');
                exit();
            }
        }
    }

    // Convert array of image paths to a comma-separated string
    $imageList = implode(',', $imagePaths);

    // Handle amenities (checkboxes) - Get the selected amenities from the form
    if (isset($_POST['amenities'])) {
        $amenities = $_POST['amenities'];
        // Convert array to a comma-separated string
        $amenitiesList = implode(', ', $amenities);
    } else {
        $amenitiesList = ''; // If no amenities were selected
    }

    // Insert data into the database (Update the query to save amenities)
    $sql_query = "INSERT INTO rooms (room_name, gender, capacity, description, monthly_rent, image, bh_fk) 
                  VALUES ('$roomName', '$gender', $capacity, '$amenitiesList', $monthly_rent, '$imageList', $bh_id)";

    if (mysqli_query($con, $sql_query)) {
        $_SESSION['message'] = "Successfully Added";
        $_SESSION['message_type'] = 'success';
        header('Location: mng_room.php');
    } else {
        $_SESSION['message'] = "Something went wrong: " . mysqli_error($con);
        $_SESSION['message_type'] = 'warning';
        header('Location: mng_room.php');
    }

    mysqli_close($con);  
    exit(); 
}

mysqli_close($con); 

?>
