<?php

session_start();
include('../../config/config.php');
include('../../functionCode/function.php');
include('../../middleware/middleware.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house info
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = $landlord_id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['BH-ID'] = $row['bh_id'];
} else {
    $_SESSION['message'] = "Boarding house not found";
    $_SESSION['message_type'] = "danger";
    header('Location: index.php');
    exit();
}
$bh_id = $_SESSION['BH-ID'];

$test_pass = "SELECT * FROM rooms WHERE bh_fk = '$bh_id'";
$test_pass_run = mysqli_query($con, $test_pass);

if ($test_pass_run && mysqli_num_rows($test_pass_run) > 0) {
    if (isset($_POST['submit_addBed'])) {

        $roomId = mysqli_real_escape_string($con, $_POST['roomId']);
        $bedNumber = mysqli_real_escape_string($con, $_POST['bedNumber']);
        $status = mysqli_real_escape_string($con, $_POST['status']);
    
        $uploadDir = '../room_bed_uploads/';
        $bedImage = uploadFile('bedImage', $uploadDir);
    
        // Check if the bed number already exists in the selected room
        $checkBedQuery = "SELECT bed_id FROM beds WHERE room_id = $roomId AND bed_number = '$bedNumber'";
        $checkBedResult = mysqli_query($con, $checkBedQuery);
    
        if ($checkBedResult && mysqli_num_rows($checkBedResult) > 0) {
            $_SESSION['message'] = "Bed number already exists in this room";
            $_SESSION['message_type'] = "warning";
            header('Location: mng_bed.php');
            exit();
        }
    
        $query_getCapacity = "SELECT capacity, vacant_bed, occupied_bed FROM rooms WHERE room_id = $roomId AND bh_fk = $bh_id";
        $query_getCapacity_result = mysqli_query($con, $query_getCapacity);
    
        if ($query_getCapacity_result && mysqli_num_rows($query_getCapacity_result) > 0) {
            $rowData = mysqli_fetch_assoc($query_getCapacity_result);
            $capacity = $rowData['capacity'];
            $vacant_bed = $rowData['vacant_bed'];
            $occupied_bed = $rowData['occupied_bed'];
        } else {
            $_SESSION['message'] = "Room not found";
            $_SESSION['message_type'] = "warning";
            header('Location: mng_bed.php');
            exit();
        }
    
        if ($status == 'available') {
            if ($vacant_bed < $capacity) {
                
                $vacant_bed += 1; // Increment the vacant bed count

                // Update the number of vacant beds in the room
                $updateRooms = "UPDATE rooms SET vacant_bed = $vacant_bed WHERE room_id = $roomId AND bh_fk = $bh_id";
                $updateRooms_result = mysqli_query($con, $updateRooms);

                // Insert new bed record
                $sql = "INSERT INTO beds (bed_number, room_id, status, image, bh_id) VALUES ('$bedNumber', '$roomId', '$status', '$bedImage', '$bh_id')";
                $sql_run = mysqli_query($con, $sql);

                if ($updateRooms_result && $sql_run) {
                    $_SESSION['message'] = "Successfully Added";
                    $_SESSION['message_type'] = "success";
                    header('Location: mng_bed.php');
                } else {
                    $_SESSION['message'] = "Something went wrong: " . mysqli_error($con);
                    $_SESSION['message_type'] = "warning";
                    header('Location: mng_bed.php');
                }
            } else {
                $_SESSION['message'] = "No vacant beds available";
                $_SESSION['message_type'] = "warning";
                header('Location: mng_bed.php');
            }
        } elseif ($status == 'occupied') {
            if ($occupied_bed < $capacity) {

                $occupied_bed += 1; // Increment the occupied bed count

                // Update the number of vacant and occupied beds in the room
                $updateRooms = "UPDATE rooms SET occupied_bed = $occupied_bed WHERE room_id = $roomId AND bh_fk = $bh_id";
                $updateRooms_result = mysqli_query($con, $updateRooms);

                // Insert new bed record
                $sql = "INSERT INTO beds (bed_number, room_id, status, image, bh_id) VALUES ('$bedNumber', '$roomId', '$status', '$bedImage', '$bh_id')";
                $sql_run = mysqli_query($con, $sql);

                if ($updateRooms_result && $sql_run) {
                    $_SESSION['message'] = "Successfully Added";
                    $_SESSION['message_type'] = "success";
                    header('Location: mng_bed.php');
                } else {
                    $_SESSION['message'] = "Something went wrong: " . mysqli_error($con);
                    $_SESSION['message_type'] = "warning";
                    header('Location: mng_bed.php');
                }
            } else {
                $_SESSION['message'] = "No vacant beds available";
                $_SESSION['message_type'] = "warning";
                header('Location: mng_bed.php');
            }
        } else {
            $_SESSION['message'] = "Invalid bed status";
            $_SESSION['message_type'] = "warning";
            header('Location: mng_bed.php');
        }
    
        mysqli_close($con);  // Close connection
        exit();
    }
} else {
    $_SESSION['message'] = "No Room Available!";
    $_SESSION['message_type'] = "warning";
    header('Location: mng_bed.php');
}
?>
