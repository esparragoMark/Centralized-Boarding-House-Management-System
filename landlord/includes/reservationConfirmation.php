<?php

session_start();
include('../../config/config.php');

if(isset($_POST['submit_confirm']))
{
    $booking_id = mysqli_real_escape_string($con, $_POST['booking_id']);
    $bh_name = mysqli_real_escape_string($con, $_POST['bh_name']);
    $bh_id = mysqli_real_escape_string($con, $_POST['bh_id']);
    $room_id = mysqli_real_escape_string($con, $_POST['room_id']);
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
    $guardianName = mysqli_real_escape_string($con, $_POST['guardianName']);
    $guardianContact = mysqli_real_escape_string($con, $_POST['guardianContact']);
    $check_in = mysqli_real_escape_string($con, $_POST['start_date']);
    $check_out = mysqli_real_escape_string($con, $_POST['end_date']);
    $room_no = mysqli_real_escape_string($con, $_POST['room_no']);
    $bed_no = mysqli_real_escape_string($con, $_POST['bed_no']);
    $monthly_rent = mysqli_real_escape_string($con, $_POST['monthly_rent']);
    $payment_amount = mysqli_real_escape_string($con, $_POST['payment_amount']);

    // confirm message
    $confirm_message =  mysqli_real_escape_string($con, $_POST['confirm_message']);


    // UPDATE THE STATUS TO CONFIRMED
    $update_booking_status = "UPDATE booking SET status = 'confirmed', confirm_message = '$confirm_message' WHERE booking_id = '$booking_id'";
    $update_booking_status_run = mysqli_query($con, $update_booking_status);

    if($update_booking_status_run)
    {
        // ADD TO OCCUPANT TABLE
        $add_tenant = "INSERT INTO occupants (
                                                fullname,
                                                gender,
                                                course_year_section,
                                                address,
                                                contact_number,
                                                guardian_name,
                                                guardian_contact,
                                                room_number,
                                                bed_number,
                                                monthly_rent,
                                                payment_amount,
                                                start_date,
                                                end_date,
                                                bh_name,
                                                bh_id,
                                                room_fk
                                                
                                            ) VALUES (
                                                '$fullname',
                                                '$gender',
                                                '$course',
                                                '$address',
                                                '$contact_no',
                                                '$guardianName',
                                                '$guardianContact',
                                                '$room_no',
                                                '$bed_no',
                                                '$monthly_rent',
                                                '$payment_amount',
                                                '$check_in',
                                                '$check_out',
                                                '$bh_name',
                                                '$bh_id',
                                                '$room_id'
                                            )";

        $add_tenant_run = mysqli_query($con, $add_tenant);

        if(!$add_tenant_run) {
            echo "Error in adding tenant: " . mysqli_error($con);
            exit;
        }

        // ADD TO PAYMENT TABLE
        $add_payment = "INSERT INTO payment (tenant_name, due_date, total_rent_paid, bh_id) VALUES('$fullname', '$check_out', '$payment_amount', '$bh_id')";
        $add_payment_run = mysqli_query($con, $add_payment);

        if(!$add_payment_run) {
            echo "Error in adding payment: " . mysqli_error($con);
            exit;
        }

        // UPDATE ROOM TABLE
        $update_room_table = "UPDATE rooms SET vacant_bed = vacant_bed - 1 , occupied_bed = occupied_bed + 1 WHERE room_id = '$room_id' AND room_name = '$room_no' AND bh_fk = '$bh_id'";
        $update_room_table_run = mysqli_query($con, $update_room_table);

        if(!$update_room_table_run) {
            echo "Error in updating room table: " . mysqli_error($con);
            exit;
        }

        // UPDATE BED TABLE
        $update_bed_table = "UPDATE beds SET status = 'occupied' WHERE bed_number = '$bed_no' AND room_id = '$room_id' AND bh_id = '$bh_id'";
        $update_bed_table_run = mysqli_query($con, $update_bed_table); 

        if(!$update_bed_table_run) {
            echo "Error in updating bed table: " . mysqli_error($con);
            exit;
        }

        $_SESSION['message'] = "Successfully Confirmed";
        $_SESSION['message_type'] = "success";
        header('Location: record.php');
        exit;

    }
    else {
        // Add error handling here
        echo "Error in updating booking status: " . mysqli_error($con);
        $_SESSION['message'] = "Something went wrong!";
        $_SESSION['message_type'] = "warning";
        header('Location: reservation.php');
        exit;
    }
}
elseif(isset($_POST['submit_reject']))
{
    $booking_id = mysqli_real_escape_string($con, $_POST['booking_id']);
    $reject_reason = mysqli_real_escape_string($con, $_POST['reject_reason']);
    $bh_id = mysqli_real_escape_string($con, $_POST['bh_id']);
    $room_id = mysqli_real_escape_string($con, $_POST['room_id']);
    $bed_no = mysqli_real_escape_string($con, $_POST['bed_no']);
    // UPDATE THE STATUS TO CONFIRMED
    $update_booking_status = "UPDATE booking SET status = 'rejected', reject_reason = '$reject_reason' WHERE booking_id = '$booking_id'";
    $update_booking_status_run = mysqli_query($con, $update_booking_status);

    if(!$update_booking_status_run)
    {
        $_SESSION['message'] = "Something went wrong!";
        $_SESSION['message_type'] = "warning";
        header('Location: reservation.php');
        exit;
    }

    // UPDATE BED STATUS
    $update_bed_status = "UPDATE beds SET status = 'available' WHERE bed_number = '$bed_no' AND room_id = '$room_id' AND bh_id = '$bh_id'";
    $update_bed_status_run = mysqli_query($con , $update_bed_status);

    echo "Something went wrong!" . mysqli_error($con);

    $_SESSION['message'] = "Successfully Rejected";
    $_SESSION['message_type'] = "success";
    header('Location: reservation.php');
}

$con->close();
?>