<?php

session_start();
include('../../config/config.php');
include('../../middleware/middleware.php');

// Get landlord ID from session
$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID
$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
}

$bh_id = $_SESSION['BH-ID'];

if(isset($_POST['submit_editTenant']))
{
    $currentId = $_POST['currentId'];
    $tenantName = $_POST['tenantName'];
    $tenantGender = $_POST['tenantGender'];
    $course_year_section = $_POST['course/year/section'];
    $tenantAddress = $_POST['tenantAddress'];
    $tenantContact = $_POST['tenantContact'];
    $guardianName = $_POST['guardian'];
    $guardianContact = $_POST['guardianContact'];
    $payment = $_POST['payment'];
    $enddate = $_POST['enddate'];

    // CURRENT VALUE
    $currentroom = $_POST['currentroom']; //room_name to use to get the room_id for comparing the upate roomID
    $currentbed = $_POST['currentbed'];
    $currentrent = $_POST['currentrent'];


    $current_roomID = "SELECT room_id FROM rooms WHERE room_name = '$currentroom'";
    $current_roomID_run = mysqli_query($con , $current_roomID);
    $current_room_data = mysqli_fetch_array($current_roomID_run);

    $currentRoomId = $current_room_data['room_id']; // current_room_id

    // UPDATE VALUE
    $roomNumber = $_POST['roomNumber']; //this is already an id
    $bedNumber = $_POST['bedNumber'];
    $monthlyRent = $_POST['monthlyRent'];

    if(is_numeric($roomNumber) && is_numeric($bedNumber) && !empty($monthlyRent) )
    {
        $roomName = "SELECT room_name FROM rooms WHERE room_id = '$roomNumber'";
        $roomName_run = mysqli_query($con , $roomName);
        $room_data = mysqli_fetch_array($roomName_run);
    
        $result_RoomName = $room_data['room_name']; //selected room number

        $update_occupant = "UPDATE occupants SET fullname = '$tenantName', gender = '$tenantGender', course_year_section = '$course_year_section', address = '$tenantAddress',
                            contact_number = '$tenantContact', guardian_name = '$guardianName', guardian_contact = '$guardianContact',room_number = '$result_RoomName', bed_number = '$bedNumber', monthly_rent = '$monthlyRent',payment_amount = '$payment', end_date = '$enddate' WHERE occupant_id = '$currentId' AND bh_id = '$bh_id'";

        $update_occupant_run = mysqli_query($con, $update_occupant); 
        
        if($update_occupant_run){

            // updating only the bed number
            if( $roomNumber == $currentRoomId)
            {
               if($bedNumber != $currentbed)
               {
                    $updateBed = "UPDATE beds SET status = 'occupied' WHERE bed_number = '$bedNumber' AND room_id = '$roomNumber'";
                    $updateBed_run = mysqli_query($con , $updateBed);

                    $updateCurrentBed  = "UPDATE beds SET status = 'available' WHERE bed_number = '$currentbed' AND room_id = '$currentRoomId'";
                    $updateCurrentBed_run = mysqli_query($con , $updateCurrentBed);


                    $_SESSION['message'] = "Successfully Updated";
                    $_SESSION['message_type'] = "success";
                    header('Location: record.php');
               }
            }
            else{

                // update the new selected room and bed
                $updateBed = "UPDATE beds SET status = 'occupied' WHERE bed_number = '$bedNumber' AND room_id = '$roomNumber'";
                $updateBed_run = mysqli_query($con , $updateBed);

                $updateRoom = "UPDATE rooms SET vacant_bed = vacant_bed - 1 , occupied_bed = occupied_bed + 1 WHERE room_id = '$roomNumber' AND bh_fk = '$bh_id'";
                $updateRoom_run = mysqli_query($con, $updateRoom);


                // update the current room and bed
                $updateCurrentBed = "UPDATE beds SET status = 'available' WHERE bed_number = '$currentbed' AND room_id = '$currentRoomId'";
                $updateCurrentBed_run = mysqli_query($con , $updateCurrentBed);

                $updateCurrentRoom = "UPDATE rooms SET vacant_bed = vacant_bed + 1 , occupied_bed = occupied_bed - 1 WHERE room_id = '$currentRoomId'  AND bh_fk = '$bh_id' ";
                $updateCurrentRoom_run = mysqli_query($con , $updateCurrentRoom);


                $_SESSION['message'] = "Successfully Updated";
                $_SESSION['message_type'] = "success";
                header('Location: record.php');
   
            }

        }else{

                 $_SESSION['message'] = "Something went wrong: " . mysqli_error($con);
                $_SESSION['message_type'] = "danger";
                header('Location: edit_Tenant.php');

        }

    }
    else{

        $update_occupant = "UPDATE occupants SET fullname = '$tenantName', gender = '$tenantGender', course_year_section = '$course_year_section', address = '$tenantAddress',
        contact_number = '$tenantContact', guardian_name = '$guardianName', guardian_contact = '$guardianContact', room_number = '$currentroom', bed_number = '$currentbed', monthly_rent = '$currentrent', payment_amount = '$payment', end_date = '$enddate' WHERE occupant_id = '$currentId' AND bh_id = '$bh_id'";
        $update_occupant_run = mysqli_query($con, $update_occupant);   

       
       $_SESSION['message'] = "Successfully Updated";
       $_SESSION['message_type'] = "success";
       header('Location: record.php');
        
    }

}

$con->close();

?>