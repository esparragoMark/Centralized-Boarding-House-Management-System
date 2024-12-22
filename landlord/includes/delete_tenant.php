<?php
session_start();
include('../../config/config.php');
include('../../middleware/middleware.php');

if (isset($_POST['deleteTenant'])) {
    $tenant_id = mysqli_real_escape_string($con, $_POST['occupant_id']);

    // Fetch boarding house ID
    $landlord_id = $_SESSION['auth_landlord']['id'];
    $query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['BH-ID'] = $row['bh_id'];
    } else {
        echo 500;
        exit;
    }

    $bh_id = $_SESSION['BH-ID'];

    // Fetch the tenant data
    $tenant_query = "SELECT * FROM occupants WHERE occupant_id = '$tenant_id'";
    $tenant_query_run = mysqli_query($con, $tenant_query);
    $tenant_data = mysqli_fetch_assoc($tenant_query_run);

    if (!$tenant_data) {
        echo 500; // Tenant not found
        exit;
    }

    // Get the room_id
    $room_number = mysqli_real_escape_string($con, $tenant_data['room_number']);
    $room_id_query = "SELECT room_id FROM rooms WHERE room_name = '$room_number'";
    $room_id_query_run = mysqli_query($con, $room_id_query);
    $room_data = mysqli_fetch_assoc($room_id_query_run);
    $room_id = $room_data['room_id'];

    // Bed number
    $bed_number = mysqli_real_escape_string($con, $tenant_data['bed_number']);

    // Delete the tenant
    $delete_query = "DELETE FROM occupants WHERE occupant_id = '$tenant_id' AND bh_id = '$bh_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        // Update bed status
        $updatebeds = "UPDATE beds SET status = 'available' WHERE bed_number = '$bed_number' AND room_id = '$room_id'";
        $updatebeds_run = mysqli_query($con, $updatebeds);

        if ($updatebeds_run) {
            // Update room status
            $updaterooms = "UPDATE rooms SET vacant_bed = vacant_bed + 1, occupied_bed = occupied_bed - 1 WHERE room_id = '$room_id'";
            $updaterooms_run = mysqli_query($con, $updaterooms);

            if ($updaterooms_run) {
                echo 200;
            } else {
                echo 500; // Error updating room status
            }
        } else {
            echo 500; // Error updating bed status
        }
    } else {
        echo 500; // Error deleting tenant
    }
}

$con->close();
?>
