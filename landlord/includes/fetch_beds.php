<?php 

include('../../config/config.php');

$selectedRoom = $_GET["value"];
$status = "available";

// Escape input
$selectedRoom_get = mysqli_real_escape_string($con, $selectedRoom);

$monthlyRent_sql = "SELECT monthly_rent FROM rooms WHERE room_id = '$selectedRoom_get'";
$getRent_result = mysqli_query($con, $monthlyRent_sql);
$monthlyRent = '';

if ($getRent_result && mysqli_num_rows($getRent_result) > 0) {
    $row = mysqli_fetch_assoc($getRent_result);
    $monthlyRent = htmlspecialchars($row["monthly_rent"]);
    $monthlyRent = trim($monthlyRent); // Remove any extra whitespace
}

// Fetch available beds
$getbed_sql = "SELECT bed_number FROM beds WHERE room_id = '$selectedRoom_get' AND status = '$status'";
$result = mysqli_query($con, $getbed_sql);

$bedOptions = '';

if(mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $bedOptions .= "<option>" . htmlspecialchars($rows["bed_number"]) . "</option>";
    }
} else {
    $bedOptions = "<option>No beds available</option>";
}


echo $bedOptions . '||' . $monthlyRent;

?> 
