<?php
session_start();
include("../../config/config.php");

if(isset($_POST['landlord_id'])) {
    
    $landlord_id = mysqli_real_escape_string($con, $_POST['landlord_id']);

    $deleteQuery = "DELETE FROM landlords_acc WHERE landlord_id = '$landlord_id'";

    if(mysqli_query($con, $deleteQuery)) {
        header("Location: account.php");
        exit();
    } else {
     
        $_SESSION['message'] = "Failed to delete the college.";
        $_SESSION['message_type'] = "warning";
        header("Location: account.php"); 
    }
} else {
   
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "error";
    header("Location: account.php"); 
    exit();
}
?>
