<?php 
// Set the cache control header
header("Cache-Control: max-age=3600"); ?>

<?php include "contact_header.php"; ?>
<?php include "database.php"; ?>
<?php include "functions.php"; ?>


<!-- Background image for the contact area -->
<div class="container_images_contact">
<div class="container_image_contact_1">
    <img src="../img/contact_1.svg" alt="Contact" />
</div>
<div class="container_image_contact_2">
    <img src="../img/contact_2.svg" alt="Contact" />
</div>
</div>

<!-- The main menu button -->
<div class="mainmenu">
    <a href="index.php">Main menu</a> 
</div>      

<!-- Contact container -->
<div class="container_form_contact">
    <h1>Contact Form</h1>

<?php 
// Checking if the form is submitted
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = "teamofgismaps@gmail.com";
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    $header = "From: ".$_POST['fullname']." <".$_POST['email'].">";
    
    // send email
    $success = mail($to, $subject, $body, $header);

    if ($success) {
        // Email sent successfully
        set_msg("Thank you for your message", "green_color");
    } else {
        // Email failed to send
        set_msg("An error occured, message never sent", "red_color");
    }
}

// Show the message
show_msg(); 
?>

<!--Creating a form -->    
<form method="post" action="">
<div class="form-group">
        <h2>Full Name</h2>
        <input type="fullname" class="form-control" name="fullname" placeholder="Enter full name :">
    </div>
    <div class="form-group">
        <h2>Email</h2>
        <input type="email" class="form-control" name="email" placeholder="Enter email address:">
    </div>
    <div class="form-group">
        <h2>Subject</h2>
        <input type="text"  class="form-control" name="subject" placeholder="Enter subject:" >
    </div>
    <div class="form-group">
        <h2>Message</h2>
        <textarea class="form-control" name="body"  cols="30" rows="10" placeholder="Please add your content:"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn_login" value="Submit" name="submit">
    </div>
</form>
</div>
 
<!-- Script connection -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>

</body>
</html>

<?php include "./footer.php" ?>