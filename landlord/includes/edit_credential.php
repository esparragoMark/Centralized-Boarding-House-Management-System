<?php
session_start();
include('../../config/config.php');
include('../../functionCode/function.php');

$landlord_id = $_SESSION['auth_landlord']['id'];

if(isset($_POST['update'])) {

    // Check if query to fetch existing credentials runs successfully
    $get_credentials = "SELECT * FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
    $get_credentials_run = mysqli_query($con, $get_credentials);

    if (!$get_credentials_run) {
        $_SESSION['message'] = "Error fetching credentials!";
        $_SESSION['message_type'] = "warning";
        header('Location: crendentialInfo.php');
        exit(); // stop further execution
    }

    $data = mysqli_fetch_assoc($get_credentials_run);

    // Get the values from the form
    $owner_name = mysqli_real_escape_string($con, $_POST['ownerName']);
    $owner_contact = mysqli_real_escape_string($con, $_POST['ownerContact']);
    $owner_email = mysqli_real_escape_string($con, $_POST['ownerEmail']);
    $owner_address = mysqli_real_escape_string($con, $_POST['ownerAddress']);
    $bh_name = $_POST['houseName'];
    $bh_location = isset($_POST['houseLocation']) ? mysqli_real_escape_string($con, $_POST['houseLocation']) : $data['house_location'];
    $terms_and_conditions = $_POST['termsAndConditions'];

    // Directory for file uploads
    $uploadDir = '../landlord_uploads/';

    // Upload files (use $_FILES instead of $_POST)
    $bh_image = isset($_FILES['bhImage']['name']) && $_FILES['bhImage']['name'] != '' ? uploadFile('bhImage', $uploadDir) : $data['bhImage'];
    $major_permit = isset($_FILES['majorPermit']['name']) && $_FILES['majorPermit']['name'] != '' ? uploadFile('majorPermit', $uploadDir) : $data['major_permit'];
    $DTI = isset($_FILES['dit']['name']) && $_FILES['dit']['name'] != '' ? uploadFile('dit', $uploadDir) : $data['DTI'];
    $BIR = isset($_FILES['bir']['name']) && $_FILES['bir']['name'] != '' ? uploadFile('bir', $uploadDir) : $data['BIR'];
    $BFP = isset($_FILES['fireSafety']['name']) && $_FILES['fireSafety']['name'] != '' ? uploadFile('fireSafety', $uploadDir) : $data['fire_safety_path'];
    $ATO = isset($_FILES['ato']['name']) && $_FILES['ato']['name'] != '' ? uploadFile('ato', $uploadDir) : $data['ATO'];
    $barangay_permit = isset($_FILES['barangayPermit']['name']) && $_FILES['barangayPermit']['name'] != '' ? uploadFile('barangayPermit', $uploadDir) : $data['barangay_permit_path'];

    // Update query directly
    $update_query = "UPDATE boarding_house_registration 
                    SET owner_name = '$owner_name', 
                        owner_phone = '$owner_contact', 
                        owner_email = '$owner_email', 
                        owner_address = '$owner_address', 
                        house_name = '$bh_name', 
                        house_location = '$bh_location', 
                        bhImage = '$bh_image', 
                        terms_and_conditions = '$terms_and_conditions', 
                        major_permit = '$major_permit', 
                        DTI = '$DTI', 
                        BIR = '$BIR', 
                        fire_safety_path = '$BFP', 
                        ATO = '$ATO', 
                        barangay_permit_path = '$barangay_permit' 
                    WHERE landlord_id = '$landlord_id'";

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Successfully saved";
        $_SESSION['message_type'] = "success";
        header('Location: crendentialInfo.php');
    } else {
        $_SESSION['message'] = "Something went wrong!";
        $_SESSION['message_type'] = "warning";
        header('Location: crendentialInfo.php');
    }
}
