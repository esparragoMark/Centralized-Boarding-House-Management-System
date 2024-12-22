<?php

session_start();
include('../../config/config.php');

// Get landlord ID from session
$landlord_id = $_SESSION['auth_landlord']['id'];

// Fetch boarding house ID
$query = "SELECT bh_id, house_name FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];
    $_SESSION['BH-NAME'] = $row['house_name'];
}
else{
    $_SESSION['message'] = "Please submit your credentials";
    $_SESSION['message_type'] = "warning";
    header('Location: credential.php');
    exit;
}

$bh_id = $_SESSION['BH-ID'];
$bh_name =  $_SESSION['BH-NAME'];

// Handle form submission
if (isset($_POST['submit_addTenant'])) {
    $tenantName = mysqli_real_escape_string($con, $_POST['tenantName']);
    $tenantGender = mysqli_real_escape_string($con, $_POST['tenantGender']);
    $tenantCourse = mysqli_real_escape_string($con, $_POST['tenantCourse']);
    $tenantAddress = mysqli_real_escape_string($con, $_POST['tenantAddress']);
    $tenantContact = mysqli_real_escape_string($con, $_POST['tenantContact']);
    $guardianName = mysqli_real_escape_string($con, $_POST['guardian']);
    $guardianContact = mysqli_real_escape_string($con, $_POST['guardianContact']);
    $selectedRoom = mysqli_real_escape_string($con, $_POST['roomNumber']); //this is the room id
    $bedNumber = mysqli_real_escape_string($con, $_POST['bedNumber']);
    $monthlyRent = mysqli_real_escape_string($con, $_POST['monthlyRent']);
    $payment = mysqli_real_escape_string($con, $_POST['payment']);
    $end_date = mysqli_real_escape_string($con, $_POST['dateEnd']);



    //getting the room number based on the selected room
    $room_query = "SELECT room_name FROM rooms WHERE room_id = '$selectedRoom' AND bh_fk = '$bh_id'";
    $room_query_run = mysqli_query($con, $room_query);

    if($room_query_run && mysqli_num_rows($room_query_run) > 0) {
        $room_row = mysqli_fetch_assoc($room_query_run);
        $room_number = $room_row['room_name']; // use for room number
    } else {
        $_SESSION['message'] = "Room number not found!";
        $_SESSION['message_type'] = "warning";
        header('Location: add_Tenant.php');
        exit;
    }

    // Insert tenant into occupants table
    $insertQueryAdd_Tenant = "INSERT INTO occupants (fullname, gender, course_year_section, address, contact_number, guardian_name, guardian_contact,room_number, bed_number, monthly_rent, payment_amount, end_date, bh_name , bh_id, room_fk)
                            VALUES ('$tenantName', '$tenantGender', '$tenantCourse', '$tenantAddress', '$tenantContact', '$guardianName','$guardianContact','$room_number', '$bedNumber', '$monthlyRent','$payment','$end_date','$bh_name','$bh_id', '$selectedRoom')";
    $insertQuery_run = mysqli_query($con, $insertQueryAdd_Tenant);

    if($insertQuery_run) {

        // add into the table of payment

        $add_payment = "INSERT INTO payment (tenant_name, due_date, total_rent_paid, bh_id)VALUES('$tenantName', '$end_date', '$payment', '$bh_id')";
        $add_payment_run = mysqli_query($con, $add_payment);


        // Update bed status
        $updateBed = "UPDATE beds SET status = 'occupied' WHERE bed_number = '$bedNumber' AND room_id = '$selectedRoom'";
        $updateBed_run = mysqli_query($con, $updateBed);

        if($updateBed_run) {
            // Update room occupancy
            $updateRoom = "UPDATE rooms SET vacant_bed = vacant_bed - 1, occupied_bed = occupied_bed + 1 WHERE room_id = '$selectedRoom'";
            $updateRoom_run = mysqli_query($con, $updateRoom);

            if (!$updateRoom_run) {
                $_SESSION['message'] = "Failed to update room information: " . mysqli_error($con);
                $_SESSION['message_type'] = "warning";
                header('Location: add_Tenant.php');
                exit;
            }
        } else {
            $_SESSION['message'] = "Failed to update bed status: " . mysqli_error($con);
            $_SESSION['message_type'] = "warning";
            header('Location: add_Tenant.php');
            exit;
        }

        $_SESSION['message'] = "Added Successfully";
        $_SESSION['message_type'] = "success";
        header('Location: record.php');
    } else {
        $_SESSION['message'] = "Failed to add tenant: " . mysqli_error($con);
        $_SESSION['message_type'] = "warning";
    }
}
$con->close();
?>