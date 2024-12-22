<?php
session_start();
include("../../config/config.php");

$landlord_id = $_SESSION['auth_landlord']['id'];

$query = "SELECT bh_id FROM boarding_house_registration WHERE landlord_id = '$landlord_id'";
$result = $con->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['BH-ID'] = $row['bh_id'];

    $bh_id = $_SESSION['BH-ID'];
}

if(isset($_POST['submit_payment']))
{
   $occupant_id = $_POST['occupantID'];
   $occupantName = $_POST['occupantName'];
   $amount = $_POST['amount'];
   $dueDate = $_POST['dueDate'];
   $monthlyRent = $_POST['monthlyRent'];

   $var_test = ($amount % $monthlyRent );
  
   if($var_test != 0)
   {
     $_SESSION['message'] = "Please Enter Exact Amount";
     $_SESSION['message_type'] = "warning";
     header('Location: payment.php');
     exit;
   }

   $process = "UPDATE occupants SET payment_amount = '$amount', end_date = '$dueDate' WHERE occupant_id = '$occupant_id' AND bh_id = '$bh_id'";
   $process_run = mysqli_query($con, $process);

   if($process_run){

        $payment_add = "INSERT INTO payment(tenant_name, due_date , total_rent_paid, bh_id)VALUES('$occupantName', '$dueDate','$amount', '$bh_id' )";
        $payment_add_run = mysqli_query($con, $payment_add);

        if($payment_add_run)
        {
            $_SESSION['message'] = "Payment Done";
            $_SESSION['message_type'] = "success";
            header('Location: payment.php');    
        }
        else{
            $_SESSION['message'] = "Something went wrong!";
            $_SESSION['message_type'] = "warning";
            header('Location: payment.php'); 
        }

   }else{
        $_SESSION['message'] = "Payment Denied!";
        $_SESSION['message_type'] = "warning";
        header('Location: payment.php'); 
   }


}
$con->close();
?>