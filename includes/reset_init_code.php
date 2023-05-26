<?php 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                            //Send using SMTP
    $mail->Host       = 'mail@teamofgis.com';      //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                  //Enable SMTP authentication
    $mail->Username   = 'mail@teamofgis.com';    //SMTP username
    $mail->Password   = 'password';              //SMTP password
    $mail->SMTPSecure = 'ssl';   //Enable implicit TLS encryption
    $mail->Port       = 465;    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('teamofgismaps@gmail.com', 'Web GIS Team');
    $mail->addAddress('teamofgismaps@gmail.com');     //Add a recipient         
    $mail->addReplyTo('teamofgismaps@gmail.com', 'No reply');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = 'Please find the link for the requested password reset <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}