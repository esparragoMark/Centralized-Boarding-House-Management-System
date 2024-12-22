<?php

session_start();
include('../../config/config.php');
include('../../functionCode/function.php');
include('../../middleware/middleware.php');

if (isset($_POST['submit_editBed'])) {
    $bedId = mysqli_real_escape_string($con, $_POST['bedId']); 
    $roomId = mysqli_real_escape_string($con, $_POST['roomId']);
    $bedNumber = mysqli_real_escape_string($con, $_POST['bedNumber']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $currentRoomName = mysqli_real_escape_string($con, $_POST['currentRoomName']);

    $updateImage = false;
    $imageFileName = '';

    // Fix the query to match the correct variable
    $sql = "SELECT room_id FROM rooms WHERE room_name = '$currentRoomName'";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_room_id = $row['room_id'];
       

    } else {
        $_SESSION['message'] = "Current room not found";
        $_SESSION['message_type'] = 'error';
        header("Location: mng_bed.php");
        exit();
    }

    // Check for duplicate bed number in the selected room
    $sql = "SELECT * FROM beds WHERE bed_number = '$bedNumber' AND room_id = '$roomId' AND bed_id != '$bedId'";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        $_SESSION['message'] = "Bed number already exists in the selected room";
        $_SESSION['message_type'] = 'error';
        header("Location: mng_bed.php");
        exit();
    }

    // Fetch the current status and room ID of the bed being edited
    $sql = "SELECT status, room_id FROM beds WHERE bed_id = '$bedId'";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $currentStatus = $row['status'];
    $currentRoomId = $row['room_id'];

   
    // Update vacant and occupied bed counts if the status has changed
    if ($roomId == $current_room_id || empty($roomId) || !is_numeric($roomId) ) {
        if ($currentStatus != $status) {
            if ($status == 'available') {
                $sql = "UPDATE rooms SET vacant_bed = vacant_bed + 1 WHERE room_id = '$currentRoomId'";
                $con->query($sql);

                $sql_current = "UPDATE rooms SET occupied_bed = occupied_bed - 1 WHERE room_id = '$currentRoomId'";
                $con->query($sql_current);
            } elseif ($status == 'occupied') {
                $sql = "UPDATE rooms SET vacant_bed = vacant_bed - 1 WHERE room_id = '$currentRoomId'";
                $con->query($sql);

                $sql_current = "UPDATE rooms SET occupied_bed = occupied_bed + 1 WHERE room_id = '$currentRoomId'";
                $con->query($sql_current);
            }
        }

        if (!empty($_FILES['bedImage']['name'])) {
            // Get current image filename from the database
            $sql = "SELECT image FROM beds WHERE bed_id = $bedId";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $currentImage = $row['image'];

            // Upload new image
            $uploadDir = "../room_bed_uploads/";
            $imageFileName = uploadFile('bedImage', $uploadDir);

            if ($imageFileName) {
                $updateImage = true;

                // Delete old image file
                if (!empty($currentImage) && file_exists($uploadDir . $currentImage)) {
                    unlink($uploadDir . $currentImage);
                }
            } else {
                $_SESSION['message'] = "Error uploading the image";
                $_SESSION['message_type'] = 'warning';
                header("Location: mng_bed.php");
                exit();
            }
        }

        // Update bed record
        if ($updateImage) {
            $sql = "UPDATE beds SET bed_number = '$bedNumber', room_id = '$currentRoomId', status = '$status', image = '$imageFileName' WHERE bed_id = '$bedId'";
        } else {
            $sql = "UPDATE beds SET bed_number = '$bedNumber', room_id = '$currentRoomId', status = '$status' WHERE bed_id = '$bedId'";
        }

        if ($con->query($sql)) {
            $_SESSION['message'] = "Updated successfully";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating bed: " . $con->error;
            $_SESSION['message_type'] = 'error';
        }
    } else {
        // Update vacant bed count in the new room
        $sql = "UPDATE rooms SET vacant_bed = vacant_bed + 1 WHERE room_id = '$roomId'";
        $con->query($sql);

        // Update occupied bed count in the current room
        $sql = "UPDATE rooms SET vacant_bed = vacant_bed - 1 WHERE room_id = '$current_room_id'";
        $con->query($sql);

        if (!empty($_FILES['bedImage']['name'])) {
            // Get current image filename from the database
            $sql = "SELECT image FROM beds WHERE bed_id = $bedId";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $currentImage = $row['image'];

            // Upload new image
            $uploadDir = "../room_bed_uploads/";
            $imageFileName = uploadFile('bedImage', $uploadDir);

            if ($imageFileName) {
                $updateImage = true;

                // Delete old image file
                if (!empty($currentImage) && file_exists($uploadDir . $currentImage)) {
                    unlink($uploadDir . $currentImage);
                }
            } else {
                $_SESSION['message'] = "Error uploading the image";
                $_SESSION['message_type'] = 'warning';
                header("Location: mng_bed.php");
                exit();
            }
        }

        // Update bed record
        if ($updateImage) {
            $sql = "UPDATE beds SET bed_number = '$bedNumber', room_id = '$roomId', status = '$status', image = '$imageFileName' WHERE bed_id = '$bedId'";
        } else {
            $sql = "UPDATE beds SET bed_number = '$bedNumber', room_id = '$roomId', status = '$status' WHERE bed_id = '$bedId'";
        }

        if ($con->query($sql)) {
            $_SESSION['message'] = "Updated successfully";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating bed: " . $con->error;
            $_SESSION['message_type'] = 'error';
        }
    }

    mysqli_close($con);
    header("Location: mng_bed.php");
    exit();
}
?>
