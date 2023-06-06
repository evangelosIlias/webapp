<?php 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

// Initializing the error with an empty array
$error = array();

// CRequesting the crendentilas from user basedon email address once we hit the sumbit from the form
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $stmt = $cms_pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the email of user exists in database
    if ($result) {

        $vcode = $result['validationcode'];
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.gisholics.com';                   //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'teamofgismaps@gisholics.com';           //SMTP username
            $mail->Password   = 'g!XnQ%@cdaqH43';                        //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('teamofgismaps@gisholics.com', 'Gisholics');
            $mail->addAddress($email);    
            $mail->addReplyTo('no-reply@gisholics.com', 'No reply');

            //Content
            $url = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER["PHP_SELF"]) . "/reset_request.php?vcode=$vcode";
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Your password reset link';
            $mail->Body    = "<h1>You requested a new password, please check the link below</h1>
                            Click <a href='$url'>this link</a> to reset your password";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            // Set a success message in a session variable
            $_SESSION['success_request'] = "Reset password link has been sent to {$email}";

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error[] = "The {$email} is not registered";
    }
}

// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_request'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_request']}</div>";
    unset($_SESSION['success_request']);
}

if (!empty($error)) {
    foreach ($error as $msg) {
        echo "<div class='alert alert-danger'>{$msg}</div>";
    }
}
