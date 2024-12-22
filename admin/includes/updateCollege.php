<?php
session_start();
include("../../config/config.php");

if (isset($_POST['college'])) { // Changed 'collge' to 'college'
    $college_id = $_POST['college_id']; // Ensure this matches the hidden input name in the modal
    $college = $_POST['college']; // Corrected spelling from 'colloge' to 'college'

    // Fixed the typo 'WEHRE' to 'WHERE'
    $update_query = "UPDATE colleges SET college = '$college' WHERE id='$college_id'";
    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Successfully updated"; // Changed "update" to "updated"
        $_SESSION['message_type'] = "success";
        header('Location: college.php');
        exit(); // It's good practice to use exit() after header redirection
    } else {
        $_SESSION['message'] = "Failed to update";
        $_SESSION['message_type'] = "warning";
        header('Location: college.php');
        exit(); // Use exit() after redirection
    }
} else {
    $_SESSION['message'] = "Invalid request";
    $_SESSION['message_type'] = "danger";
    header('Location: college.php');
    exit();
}
