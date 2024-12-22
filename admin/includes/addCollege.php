<?php
session_start();
include("../../config/config.php");

if(isset($_POST['btn-AddCollege']))
{
    $college = $_POST['college'];

    $sql = "INSERT INTO colleges (college)VALUES('$college')";
    $sql_run = mysqli_query($con, $sql);

    if($sql_run){
        $_SESSION['message'] = "Save";
        $_SESSION['message_type'] = "success";
        header("Location: college.php");
    }
    else{
        $_SESSION['message'] = "Someting Went Wrong!";
        $_SESSION['message_type'] = "warning";
        header("Location: college.php");
    }
}