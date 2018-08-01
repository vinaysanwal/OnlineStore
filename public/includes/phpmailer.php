<?php

function send_email($client_email, $client_name, $user_filename, $messsage){

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                     // TCP port to connect to

$mail->setFrom($client_email, 'Message from ' . $client_name . ' ');
$mail->addAddress('sanwalvinay@gmail.com', 'Support Team');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo($client_email, $client_name);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');


$file_path = 'user_files/'.$user_filename;


$mail->addAttachment($file_path);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Message from Client';
$mail->Body    = $messsage;
$mail->AltBody = $messsage;

if(!$mail->send()) {
    echo '<div class="bg-danger">Message could not be sent. </div>';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo '<div class="bg-success">Message has been sent. </div>';
}



}


function email_user($client_email, $client_name, $filename, $messsage){

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = '';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';                 // SMTP username
$mail->Password = '';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('sanwalvinay@gmail.com', 'Message from onlinestalkers.Com ');
$mail->addAddress($client_email, $client_name);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('no-reply@onlinestalkers.com', 'Payment Details');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');


$file_path = 'package_files/'.$filename;


$mail->addAttachment($file_path);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Message from Virtualines.Com';
$mail->Body    = $messsage;
$mail->AltBody = 'Your Order has been processed. Please Download this email message to view the details. Also find attached your Purchased File';

if(!$mail->send()) {
    echo '<div class="bg-danger">Message could not be sent. </div>';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo '<div class="bg-success text-center">Message has been sent. </div>';
}



}








?>
