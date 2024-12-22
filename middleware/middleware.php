<?php 
if(isset($_SESSION['authentication']))
{
     if(isset($_SESSION['auth_user']))
        {
            $_SESSION['message'] = "You are not authorized to access this page";
            $_SESSION['message_type'] = 'warning';
            header('Location: ../../index.php'); // Redirect to user dashboard
            exit(0);
        } 
}
else
{
    $_SESSION['message'] = "Login to continue";
    $_SESSION['message_type'] = 'warning';
    header('Location: ../../login.php');
    exit(0);
}
?>