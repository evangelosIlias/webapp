<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<?php include "./database.php"; ?>
<?php include "./functions.php"; ?>
<?php include "./login_header.php"; ?>

<!-- Background image for the login area -->
<div class="container_images_login">
<div class="container_image_login_1">
    <img src="../img/login_1.svg" alt="Login" />
</div>
<div class="container_image_login_2">
    <img src="../img/login_2.svg" alt="Login" />
</div>
</div>

<!-- Login container -->
<div class="container_form_login">
    <h1>Please Login</h1>
<?php include "./login_init_code.php"?> 
<?php 
    if (logged_in()) {
        $email = $_SESSION['email'];
        $username = $_SESSION['username'];
        $user_role = $_SESSION['user_role'];  
        redirect_index("index.php");
    }     
?>
 
<!--Creating a form -->    
<form action="login.php" method="post">
    <div class="form-group">
        <input type="email" value= "<?php echo $email ?>" class="form-control" name="email" placeholder="Email:">
    </div>
    <div class="form-group">
        <input type="password" value= "<?php echo $pword ?>" class="form-control" name="password" placeholder="Password:">
    </div>
    <div class="form-group">
        <input type="checkbox" class="" name="remember" value="on">
        <label for="remember">Agree to stay logged in</label>
    </div>
    <div class="form-group">
        <input type="submit" class="btn_login" value="Login" name="submit">
    </div>
    <div>
        <p>Don't have an Account?<a href="../index.php"> Register here</a></p>   
    </div>
    <div>
        <a href="reset_password.php" class="forgot_password"> Forgot Password?</a>
    </div>
</form>
</div>

<!-- Script connection -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>

<!-- Scroll reaveal --> 
<script src="https://unpkg.com/scrollreveal"></script>
<script src="../js/login.js"></script>
</body>
</html>

<?php include "./footer.php" ?>




