<?php
session_start();
include('../../config/config.php');
include('../../middleware/middleware.php');

if (isset($_POST['deleteBedBtn'])) {
    $bed_id = mysqli_real_escape_string($con, $_POST['bed_id']);

    // Fetch the bed data
    $bed_query = "SELECT * FROM beds WHERE bed_id = '$bed_id'";
    $bed_query_run = mysqli_query($con, $bed_query);
    $bed_data = mysqli_fetch_array($bed_query_run);

    $image = $bed_data['image'];
    $room_id = $bed_data['room_id'];
    $status = $bed_data['status']; // Assuming 'status' is a column in the beds table

    // Delete the bed
    $delete_query = "DELETE FROM beds WHERE bed_id = '$bed_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        // Remove the bed image if it exists
        if (file_exists('../room_bed_uploads/' . $image)) {
            unlink('../room_bed_uploads/' . $image);
        }

        // Update the room's vacant_bed or occupied_bed depending on the status
        if ($status == 'available') {
            $sql = "UPDATE rooms SET vacant_bed = vacant_bed - 1 WHERE room_id = '$room_id'";
        } elseif ($status == 'occupied') {
            $sql = "UPDATE rooms SET occupied_bed = occupied_bed - 1 WHERE room_id = '$room_id'";
        }

        $con->query($sql);
        echo 200;
    } else {
        echo 500;
    }
}

$con->close();
?>
