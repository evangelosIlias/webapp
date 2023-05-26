<?php 
// Creating empty variables for the Form Creation to avoid the warning
$fname = "";
$lname = "";
$username = "";
$email = "";
$email_conf = "";
$pword = "";
$pword_conf = "";
$user_role = "";

// Initialiazing the error with an empty array 
$error = array();

// Get the values from HTML form and request these values from Server
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email_conf = filter_var($_POST['email_confirm'], FILTER_SANITIZE_EMAIL);
    $pword = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pword_conf = filter_var($_POST['password_confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_role = filter_var($_POST['user_role'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     
// Giving an error if not all the fields are filled on the form
if (empty($fname) 
    || empty($lname)
    || empty($username)
    || empty($email)
    || empty($email_conf)
    || empty($pword)
    || empty($pword_conf)) { 
    $error[] = "Please fill in the required fields below to add a user";
} else {

    // Checking string character of First name
    if (strlen($fname) < 3){
        $error[] = "First name must be at least 3 characters";
    }

    // Checking string character of Last name
    if (strlen($lname) < 3){
        $error[] = "Last name must be at least 3 characters";
    }

    // // Checking string character of username name
    if (username_duplicate($cms_pdo, $username)) {
        $error[] = "Seems the user with Username: '{$username}' is already registered, try a different username";
    }

    // Checking the password rule of 6 characters at least
    if (strlen($pword) < 6){
        $error[] = "Password must be at least 6 characters";
    }

    // Checking the password matches the confirm password
    if ($pword !== $pword_conf) {
        $error[] = "Password does not match";  
    }

    // Checking the email matches the confirm email
    if ($email !== $email_conf) {
        $error[] = "Email addresses does not match";
    }

    // Checking first if the email exists on database, if exists will drop an error
    if (check_duplicates_values($cms_pdo, "users", "email", $email) != 0) {
        $error[] = "Seems the user with e-mail: '{$email}' is already registered";
    }

    // Checking if there is no error the values will added to the DataBase
    if (empty($error)){
        $vcode = encryption_gene();
            try {
                $sql = "INSERT INTO users (firstname, lastname, username,
                email, password, validationcode, 
                active, joined, last_login, user_role) VALUES (
                :firstname, 
                :lastname,
                :username,
                :email,
                :password,
                :vcode, 0, current_date, current_date,
                :user_role
                )";
                // Preparing the sql
                $stmnt = $cms_pdo->prepare($sql);
                
                // Adding associative array with five key-value pairs
                $user_data = [
                    ':firstname' => ucfirst(strtolower($fname)),
                    ':lastname' => ucfirst(strtolower($lname)),
                    ':username' => strtolower($username),
                    ':email' => strtolower($email),
                    ':password' => password_hash($pword, PASSWORD_BCRYPT),
                    ':vcode' => $vcode,
                    ':user_role' => $user_role,
                ];
                // Execute the stmnt 
                $stmnt->execute($user_data);

                // Set a success message in a session variable
                $_SESSION['success_message'] = "The user'{$username}' has successfully created: Please <a href='./admin_users.php'>View All users here</a></div>";

                // keeping the values into the fields after error checking
                $fname = '';
                $lname = '';
                $username = '';
                $email = '';
                $email_conf = '';
                $pword = '';
                $pword_conf = '';
                $user_role = '';

            } catch(PDOException $e){
                echo "Error, can't add these values in the form: ".$e->getMessage();
            }
        }
    } 
} 
// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

if (!empty($error)) {
    foreach($error as $msg){
        echo "<div class='alert alert-danger'>{$msg}</div>";
    }
}
?>
<!-- Creating a form for Admin register area-->
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">    
        <label for="post_head">First Name</label>
        <input type="text" value= "<?php echo $fname?>" class="form-control" name="firstname" placeholder="Add your first name">
    </div>
    <div class="form-group">
        <label for="post_title">Last Name</label>
        <input type="text" value= "<?php echo $lname?>" class="form-control" name="lastname" placeholder="Add your last name">
    </div>
    <div class="form-group">
        <label for="post_title">User Name</label>
        <input type="text" value= "<?php echo $username?>" class="form-control" name="username" placeholder="Add your username">
    </div>
    <div class="form-group">
        <label for="user_id">User Role</label> 
        <p>Please pick up a role for the user</p><br>
        <select name="user_role" id="user_role">
        <option value="subscriber">Select Option</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Email</label>
        <input type="email" value= "<?php echo $email?>" class="form-control" name="email" placeholder="Add your email address" >
    </div>
    <div class="form-group">
        <label for="post_status">Confrim Email</label>
        <input type="text" value= "<?php echo $email_conf?>" class="form-control" name="email_confirm" placeholder="Confirm your email address:" >
    </div>
    <div class="form-group">
        <label for="img">User Image</label>
        <input value= "<?php echo $post_image ?>" type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" value= "<?php echo $pword?>" class="form-control" name="password" placeholder="Add your password" >
    </div>
    <div class="form-group">
        <label for="post_tags">Confirm Password</label>
        <input type="password" value= "<?php echo $pword_conf?>" class="form-control" name="password_confirm" placeholder="Confirm Password" >
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Add User">
    </div>
</form>
