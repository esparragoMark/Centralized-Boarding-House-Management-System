<?php
session_start();
include("config/config.php");
include("functionCode/function.php");

$authentication = $_SESSION['authentication'];

if($authentication)
{
    $userID = $_SESSION['auth_user']['id'];
    $userFullname = $_SESSION['auth_user']['name'];
    $userGender = $_SESSION['auth_user']['gender'];
    $userCourse = $_SESSION['auth_user']['course'];
    $userContact_num = $_SESSION['auth_user']['contact_number'];
    $userAddress = $_SESSION['auth_user']['address'];
    $userGuardian = $_SESSION['auth_user']['guardian_name'];
    $userGuardianContact = $_SESSION['auth_user']['guardian_contact'];
}
else{
    $_SESSION['message'] = "Please Login!";
    $_SESSION['message_type'] = "warning";
    header('Location: login.php');
    exit;
}

if(isset($_POST['btnBook']))
{
    // ID FOR EVERY BOARDING HOUSE 
    $bh_ID = $con->real_escape_string($_POST['bh_id']);
    $bh_NAME = $con->real_escape_string($_POST['bh_name']);
    $room_ID = $con->real_escape_string($_POST['room_id']);


    // FOR BOOKING INFORMATION
    $check_in = $con->real_escape_string($_POST['check_in']);
    $check_out = $con->real_escape_string($_POST['check_out']);
    $room_number = $con->real_escape_string($_POST['room_number']);
    $bed_number = $con->real_escape_string($_POST['bed_number']);
    $monthly_rent = $con->real_escape_string($_POST['monthly_rent']);
    $total_rent = $con->real_escape_string($_POST['total_rent']);
    $reference_no = $con->real_escape_string($_POST['reference_no']);
    
    // check the duplicated reference number
    $check_referernce = "SELECT reference_no FROM booking WHERE reference_no = '$reference_no'";
    $check_referernce_run = mysqli_query($con, $check_referernce);

    if($check_referernce_run && mysqli_num_rows($check_referernce_run) > 0)
    {
        $_SESSION['message'] = "Reference Number already Entered!";
        $_SESSION['message_type'] = "warning";
        header('Location: index.php');
        exit;
    }


    // FOR IMAGE
     $upload_Dir = "user_uploads/";
     $imageName =  uploadFile('image', $upload_Dir);

    
    // QUERY TO INSERT THE DATA IN TABLE BOOKING

    $booking_query = "INSERT INTO booking (fullname, 
                                            gender, 
                                            course, 
                                            address, 
                                            contact_no, 
                                            guardian_name,
                                            guardian_contact,
                                            room_no, 
                                            bed_no, 
                                            monthly_rent, 
                                            payment_amount, 
                                            check_in, 
                                            check_out, 
                                            image, 
                                            reference_no,
                                            user_id, 
                                            bh_name, 
                                            bh_id, 
                                            room_id) 
                                 VALUES ('$userFullname',
                                       '$userGender',
                                       '$userCourse',
                                       '$userAddress',
                                       '$userContact_num',
                                       '$userGuardian',
                                       '$userGuardianContact',
                                       '$room_number',
                                       '$bed_number',
                                       '$monthly_rent',
                                       '$total_rent',
                                       '$check_in',
                                       '$check_out',
                                       '$imageName',
                                       '$reference_no',
                                       '$userID',
                                       '$bh_NAME',
                                       '$bh_ID',
                                       '$room_ID')";

    $booking_query_run = mysqli_query($con , $booking_query);

    if($booking_query_run)
    {
        // UPDATE BED STATUS

        $update_bed_status = "UPDATE beds SET status = 'booked' WHERE bed_number = '$bed_number' AND room_id = '$room_ID' AND bh_id = '$bh_ID'";
        $update_bed_status_run = mysqli_query($con, $update_bed_status);

        if (!$update_bed_status_run) {
           
            error_log("Error updating bed status: " . mysqli_error($con));
            
            $_SESSION['message'] = "An error occurred while updating the bed status. Please try again.";
            $_SESSION['message_type'] = "error";
            header('Location: index.php');
            exit;
        }
        
        $_SESSION['message'] = "Successfully Booked";
        $_SESSION['message_type'] = "success";
        header('Location: reservation.php');
    }
    else{
        $_SESSION['message'] = "Something went wrong!" . mysqli_error($con);
        $_SESSION['message_type'] = "warning";
        header('Location: index.php');
    }

    
$con->close();
}