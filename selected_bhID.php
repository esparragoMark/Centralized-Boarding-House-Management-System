<?php
session_start();
include("config/config.php");

// Retrieve boarding house ID from query string
$boardingHouseId = $_GET['boarding_house_id'];

// Validate and set session variable
if (!empty($boardingHouseId)) {
    $_SESSION['boarding_house_id'] = $boardingHouseId;
    header("Location: BHrooms.php"); // Redirect to the room selection page
    exit();
} else {
    echo "Invalid boarding house ID.";
}
?>
