<?php
session_start();
include("../../config/config.php");
include("../../functionCode/function.php");

// ID of the single row in the table
$configId = 1;

if (isset($_FILES['uploadImage'])) {
    $uploadDir = "../../adminUploads/";
    $logoFileName = uploadFile('uploadImage', $uploadDir);

    // Check if the table has an entry with the given ID
    $checkLogo = "SELECT * FROM dislay_config WHERE id = $configId LIMIT 1";
    $checkLogo_run = mysqli_query($con, $checkLogo);

    if (mysqli_num_rows($checkLogo_run) > 0) {
        // Update existing logo entry
        $updateLogo = "UPDATE dislay_config SET image = '$logoFileName' WHERE id = $configId";
        $updateLogo_run = mysqli_query($con, $updateLogo);
    } else {
        // Insert new logo entry (if the ID doesn't exist)
        $insertLogo = "INSERT INTO dislay_config (id, image) VALUES ($configId, '$logoFileName')";
        $updateLogo_run = mysqli_query($con, $insertLogo);
    }

    if ($updateLogo_run) {
        $_SESSION['message'] = "Logo Updated";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Something Went Wrong";
        $_SESSION['message_type'] = "warning";
    }

    header('Location: ConfigureDisplay.php');
    exit;
}

if (isset($_POST['frontEndText'])) {
    $frontEndText = mysqli_real_escape_string($con, $_POST['frontEndText']);

    // Check if the table has an entry with the given ID
    $checkFrontEndText = "SELECT * FROM dislay_config WHERE id = $configId LIMIT 1";
    $checkFrontEndText_run = mysqli_query($con, $checkFrontEndText);

    if (mysqli_num_rows($checkFrontEndText_run) > 0) {
        // Update existing frontend text entry
        $updateFrontEndText = "UPDATE dislay_config SET front_end_text = '$frontEndText' WHERE id = $configId";
        $updateFrontEndText_run = mysqli_query($con, $updateFrontEndText);
    } else {
        // Insert new frontend text entry (if the ID doesn't exist)
        $insertFrontEndText = "INSERT INTO dislay_config (id, front_end_text) VALUES ($configId, '$frontEndText')";
        $updateFrontEndText_run = mysqli_query($con, $insertFrontEndText);
    }

    if ($updateFrontEndText_run) {
        $_SESSION['message'] = "Frontend Text Updated";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Something Went Wrong";
        $_SESSION['message_type'] = "warning";
    }

    header('Location: ConfigureDisplay.php');
    exit;
}

if (isset($_POST['footerText'])) {
    $footerText = mysqli_real_escape_string($con, $_POST['footerText']);

    // Check if the table has an entry with the given ID
    $checkFooterText = "SELECT * FROM dislay_config WHERE id = $configId LIMIT 1";
    $checkFooterText_run = mysqli_query($con, $checkFooterText);

    if (mysqli_num_rows($checkFooterText_run) > 0) {
        // Update existing footer text entry
        $updateFooterText = "UPDATE dislay_config SET footer_text = '$footerText' WHERE id = $configId";
        $updateFooterText_run = mysqli_query($con, $updateFooterText);
    } else {
        // Insert new footer text entry (if the ID doesn't exist)
        $insertFooterText = "INSERT INTO dislay_config (id, footer_text) VALUES ($configId, '$footerText')";
        $updateFooterText_run = mysqli_query($con, $insertFooterText);
    }

    if ($updateFooterText_run) {
        $_SESSION['message'] = "Footer Text Updated";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Something Went Wrong";
        $_SESSION['message_type'] = "warning";
    }

    header('Location: ConfigureDisplay.php');
    exit;
}
?>
