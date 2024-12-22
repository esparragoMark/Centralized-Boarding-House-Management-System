<?php
session_start();
include("../../config/config.php");

if(isset($_POST['college_id'])) {
    
    $college_id = mysqli_real_escape_string($con, $_POST['college_id']);

    $deleteQuery = "DELETE FROM colleges WHERE id = '$college_id'";

    if(mysqli_query($con, $deleteQuery)) {
        header("Location: college.php");
        exit();
    } else {
     
        $_SESSION['message'] = "Failed to delete the college.";
        $_SESSION['message_type'] = "warning";
        header("Location: college.php"); 
    }
} else {
   
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "error";
    header("Location: college.php"); 
    exit();
}
?>
