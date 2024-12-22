<?php
session_start();
include('../../config/config.php');
include('../../middleware/middleware.php');

if (isset($_POST['deleteBtn'])) {
    $room_id = mysqli_real_escape_string($con, $_POST['room_id']);

    // Fetch the room data
    $room_query = "SELECT * FROM rooms WHERE room_id = '$room_id'";
    $room_query_run = mysqli_query($con, $room_query);
    if ($room_data = mysqli_fetch_array($room_query_run)) {
        $room_image = $room_data['image'];

        // Fetch bed images associated with the room
        $bed_images_query = "SELECT image FROM beds WHERE room_id = '$room_id'";
        $bed_images_query_run = mysqli_query($con, $bed_images_query);
        while ($bed_data = mysqli_fetch_array($bed_images_query_run)) {
            $bed_image = $bed_data['image'];

            // Delete each bed image if it exists
            $bed_image_path = '../room_bed_uploads/'.$bed_image;
            if (file_exists($bed_image_path)) {
                unlink($bed_image_path);
            }
        }

        // Delete the room record
        $delete_query = "DELETE FROM rooms WHERE room_id = '$room_id'";
        if (mysqli_query($con, $delete_query)) {
            // Delete the room image if it exists
            $room_image_path = '../room_bed_uploads/'.$room_image;
            if (file_exists($room_image_path)) {
                unlink($room_image_path);
            }
            echo 200; // Success
        } else {
            echo 500; // Failure
        }
    } else {
        echo 404; // Room not found
    }
}

$con->close();
?>
