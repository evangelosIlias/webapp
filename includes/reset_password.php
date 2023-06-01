<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<?php include "./database.php"; ?>
<?php include "./reset_header.php"; ?>
<?php include "./functions.php"; ?>

<!-- Background image for the reseting password area -->
<div class="container_images_reset">
<div class="container_image_reset_1">
    <img src="../img/reset_1.svg" alt="Reset" />
</div>
</div>

<!-- The main container for reset password area -->
<div class="container_form">
    <h4>Reset your password</h4>
<?php include "./reset_init_code.php"?> 

<!-- Message container -->
<?php
show_msg('green_color'); 
?>

<!--Creating a form -->    
<form action="" method="post">
    <div class="form-group">
        <input type="email" class="form-control" name="email" placeholder="Enter your e-mail address..." autocomplete="off">
    </div>
    <div class="form-group">
        <input type="submit" class="btn_login" value="Reset Password" name="submit">
    </div>
    <div>
        <a href="login.php" class="backt_to_login">Back to login</a>
    </div>
</form>
</div>
</body>
</html>