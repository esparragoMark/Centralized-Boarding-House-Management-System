<?php

session_start();
include('../../config/config.php');
include('../../functionCode/function.php');
include('../../middleware/middleware.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house information
$query = "SELECT bh_id , house_name FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
    $_SESSION['BH-NAME'] = $row['house_name'];

    $bh_id = $_SESSION['BH-ID'];
}

if (isset($_POST['update'])) {
    // Get form data
    $roomId = $_POST['roomId'];
    $roomName = $_POST['roomName'];
    $gender = $_POST['gender'];
    $capacity = $_POST['capacity'];
    $monthlyRent = $_POST['monthlyRent'];

    // Process amenities (array to comma-separated string)
    $amenities = isset($_POST['amenities2']) ? implode(", ", $_POST['amenities2']) : '';

    // Escape the inputs to prevent SQL injection
    $roomId = mysqli_real_escape_string($con, $roomId);
    $roomName = mysqli_real_escape_string($con, $roomName);
    $gender = mysqli_real_escape_string($con, $gender);
    $capacity = mysqli_real_escape_string($con, $capacity);
    $monthlyRent = mysqli_real_escape_string($con, $monthlyRent);
    
    // Use amenities as description
    $description = mysqli_real_escape_string($con, $amenities);

    // Construct SQL query for room update
    $sql = "UPDATE rooms SET room_name='$roomName', gender='$gender', capacity='$capacity', description='$description', 
            monthly_rent='$monthlyRent' WHERE room_id='$roomId' AND bh_fk = '$bh_id'";

    if (mysqli_query($con, $sql)) {
        // Update occupants if needed
        $occupantUpdate = "UPDATE occupants SET monthly_rent = '$monthlyRent' WHERE room_fk = '$roomId' AND bh_id = '$bh_id'";
        mysqli_query($con, $occupantUpdate);

        $_SESSION['message'] = "Updated successfully";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "Error updating room: " . mysqli_error($con);
        $_SESSION['message_type'] = 'error';
    }

    mysqli_close($con);
    header("Location: mng_room.php");
    exit();
}
?>
