<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'noreplyconfirmation1234@gmail.com';           
    $mail->Password   = 'kiillnqmecoljonp';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           
    $mail->Port       = 587;                                    


    //Content
    $mail->isHTML(true);                                 

    return $mail;

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}