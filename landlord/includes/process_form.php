<?php 
session_start();
 include("../../config/config.php");
 include("../../functionCode/function.php");
 include('../../middleware/middleware.php');


 $landlord_id = $_SESSION['auth_landlord']['id'];

  $check_landlord_id = "SELECT landlord_id FROM  boarding_house_registration WHERE landlord_id = '$landlord_id' ";
  $check_landlord_id_run = mysqli_query($con, $check_landlord_id);

  if(mysqli_num_rows($check_landlord_id_run) > 0){
    $_SESSION['message'] = " You have Already Submitted";
    $_SESSION['message_type'] = "warning";
    header('Location: credential.php');
    exit;
  }

  
 if (isset($_POST['submit-btn']))
  {
    // Location
    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);

    // Sanitize and retrieve owner details
    $ownerName = mysqli_real_escape_string($con, $_POST['ownerName']);
    $ownerPhone = mysqli_real_escape_string($con, $_POST['ownerPhone']);
    $ownerEmail = mysqli_real_escape_string($con, $_POST['ownerEmail']);
    $ownerAddress = mysqli_real_escape_string($con, $_POST['ownerAddress']);

    // Sanitize and retrieve boarding house details
    $houseName = mysqli_real_escape_string($con, $_POST['houseName']);
    $houseLocation = mysqli_real_escape_string($con, $_POST['houseLocation']);
    $termsAndConditions = mysqli_real_escape_string($con, $_POST['termsAndConditions']);
   

    //upload Directory
    $uploadDir = '../landlord_uploads/';

    //upload file
    $bhImage = uploadFile('bhImage', $uploadDir);
    $majorPermit = uploadFile('majorPermit', $uploadDir);
    $dit = uploadFile('dit', $uploadDir);
    $bir = uploadFile('bir', $uploadDir);
    $fireSafety = uploadFile('fireSafety', $uploadDir);
    $ato = uploadFile('ato', $uploadDir);
    $barangayPermit = uploadFile('barangayPermit', $uploadDir);

    $sql = "INSERT INTO boarding_house_registration (owner_name, owner_phone, owner_email, owner_address, house_name, house_location, bhImage, terms_and_conditions ,major_permit, DTI, BIR, fire_safety_path, ATO, barangay_permit_path, landlord_id, latitude, longitude) 
            VALUES ('$ownerName', '$ownerPhone', '$ownerEmail', '$ownerAddress', '$houseName', '$houseLocation','$bhImage','$termsAndConditions','$majorPermit', '$dit', '$bir', '$fireSafety', '$ato', '$barangayPermit', '$landlord_id', '$latitude', '$longitude')";


    $sql_run = mysqli_query($con, $sql);
        
    if($sql_run){
        $_SESSION['message'] = "Successfully Uploaded";
        $_SESSION['message_type'] = 'success';
        header('Location: index.php');
    }
    else
    {
        $_SESSION['message'] = "Something went wrong";
        $_SESSION['message_type'] = 'warning';
        header('Location: crendential.php');
    }

    $con->close();
    }


?>