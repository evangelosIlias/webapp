<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<?php include "./includes/database.php" ?>
<?php include "./includes/functions.php" ?>
<?php include "./includes/regist_header.php" ?>

<!-- Background image for the register area -->
<div class="container_images_reg">
<div class="container_image_reg_1">
    <img src="./img/register_1.svg" alt="Register" />
</div>
<div class="container_image_reg_2">
    <img src="./img/register_2.svg" alt="Register" />
</div>
</div>

<!-- Form headers -->  
<div class="container_form_reg">
    <h1>Welcome</h1> 
    <h4>Please Register to get Access, if already have an account please login</h4>
<?php include "./includes/regist_init_code.php" ?>

<!-- Message container  after succesfully registration-->
<?php
show_msg('green_color'); 
?>

<!-- Creating a form for register area-->  
<form action="index.php" method="post">
    <div class="form-group">
        <input type="text" value= "<?php echo $fname?>" class="form-control" name="firstname" placeholder="First Name:">
    </div>
    <div class="form-group">
        <input type="text" value= "<?php echo $lname?>" class="form-control" name="lastname" placeholder="Last Name:">
    </div>
    <div class="form-group">
        <input type="text" value= "<?php echo $username?>" class="form-control" name="username" placeholder="Username:">
    </div>
    <div class="form-group">
        <input type="email" value= "<?php echo $email?>" class="form-control" name="email" placeholder="Email Address:" >
    </div>
    <div class="form-group">
        <input type="text" value= "<?php echo $email_conf?>" class="form-control" name="email_confirm" placeholder="Confirm Email Address:" >
    </div>
    <div class="form-group">
        <input type="password" value= "<?php echo $pword?>" class="form-control" name="password" placeholder="Password:" >
    </div>
    <div class="form-group">
        <input type="password" value= "<?php echo $pword_conf?>" class="form-control" name="password_confirm" placeholder="Confirm Password:" >
    </div>
    <div class="form-group">
        <input type="checkbox" class="" name="agree">
        <label for="agree">Agree to the terms and conditions</label>
    </div>
    <div class="form-group">
        <input type="submit" class="btn_register" value="Register" name="submit">
    </div>
    <div>
    <p>Already Registered?<a href='includes/login.php'> Login here</a></p>  
    </div>
</form>
</div>
</body>
</html>


