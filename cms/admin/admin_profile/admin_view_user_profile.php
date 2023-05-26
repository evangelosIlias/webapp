<?php

// Creating empty variables for the Form Creation to avoid the warning
$check_fname = "";
$check_lname = "";
$check_username = "";
$check_email = "";
$email_conf = "";
$check_pword = "";
$pword_conf = "";
$check_user_role = "";
$user_image = "";

// Initialiazing the error with an empty array 
$error = array();

// Checking for session and return the values from database
if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $cms_pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  

        $check_user_id = $user['user_id'];
        $check_fname = $user['firstname'];
        $check_lname = $user['lastname'];
        $check_username = $user['username'];
        $check_email = $user['email'];
        $check_pword = $user['password'];
        $check_user_role = $user['user_role'];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Checking if the name=submit is being set from HTML form 
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email_conf = filter_var($_POST['email_confirm'], FILTER_SANITIZE_EMAIL);
    $pword = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pword_conf = filter_var($_POST['password_confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_role = filter_var($_POST['user_role'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Giving an error if not all the fields are filled on the form
    if (empty($fname) 
        || empty($lname)
        || empty($username)
        || empty($email)
        || empty($email_conf)
        || empty($pword)
        || empty($pword_conf)) { 

        $error[] = "Please fill in the required fields below to edit user profile";
        } else {

        // Checking string character of First name
        if (strlen($fname) < 3){
            $error[] = "First name must be at least 3 characters";
        }

        // Checking string character of Last name
        if (strlen($lname) < 3){
            $error[] = "Last name must be at least 3 characters";
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
        
    // // Get the uploaded file name and path
    // $post_image = $_FILES['post_image']['name'];
    // $post_image_temp = $_FILES['post_image']['tmp_name'];

    // // Define allowed file types
    // $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/pdf", "image/eps"];

    // // Define maximum file size in bytes (5 MB)
    // $max_size = 5242880;

    // // Checking the image type if allowed and the maxsize is set to 5MB
    // if (empty($post_image)) {
    //     $error[] = "Please choose an image to upload.";
    // } elseif (!in_array($_FILES['post_image']['type'], $allowed_types)) {
    //     $error[] = "Invalid image file type. Please upload a valid image file 'jpg' 'png', 'jpeg', 'gif', 'pdf', 'eps'";
    // } elseif ($_FILES['post_image']['size'] > $max_size) {
    //     $error[] = "File size exceeds the maximum limit of 5 MB.";
    // } else {
    //     // Upload the file to server
    //     $target_dir = "./admin_upload_images/$post_image";
    //     move_uploaded_file($post_image_temp, $target_dir);
    // }
    
    // if there is no errors then updating the database
    if (empty($error)) {
        try {
            $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, password = :password, user_role = :user_role WHERE email = :email";

            // Preparing the sql
            $stmt = $cms_pdo->prepare($sql);
            
            // Adding associative array with five key-value pairs
            $user_data = [
                ':firstname' => ucfirst(strtolower($fname)),
                ':lastname' => ucfirst(strtolower($lname)),
                ':username' => strtolower($username),
                ':email' => strtolower($check_email),
                ':password' => password_hash($pword, PASSWORD_BCRYPT),
                ':user_role' => strtolower($user_role),
            ];
            
            // Execute the stmnt 
            $stmt->execute($user_data);
            
            // Set a success message in a session variable
            $_SESSION['success_message'] = "'{$username}' user profile has been successfully updated";

            // Redirect to the same page to display the message by refreshing the page
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;
            
        } catch (PDOException $e) {
            // Display an error message
            $error[] = "Error updating the posts" .  $e->getMessage();
        }
    }  
}           
} 

// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
unset($_SESSION['success_message']);
}

// Looping through the error messages and displaying if errors are encountered
if (!empty($error)) {
foreach($error as $msg){
    echo "<div class='alert alert-danger'>{$msg}</div>";
}
} 
?>

<!-- Form for post starts here-->
<form method="post" action="" enctype="multipart/form-data">
<div class="form-group">    
        <label for="firstname">First Name</label>
        <input type="text" value= "<?php echo $check_fname ?>" class="form-control" name="firstname" placeholder="Edit your first name:">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" value= "<?php echo $check_lname ?>" class="form-control" name="lastname" placeholder="Edit your last name:">
    </div>
    <div class="form-group">
        <label for="username">User Name</label>
        <input type="text" value= "<?php echo $check_username ?>" class="form-control" name="username" placeholder="Edit your username:">
    </div>
    <div class="form-group">
    <label for="user_role">User Role</label>
    <p>Please pick up a role for user profile</p><br> 
    <select name="user_role">
        <option value="admin" <?php echo ($check_user_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="subscriber" <?php echo ($check_user_role == 'subscriber') ? 'selected' : ''; ?>>Subscriber</option>
    </select>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" value= "<?php echo $check_email ?>" class="form-control" name="email" placeholder="Edit your email address:">
    </div>
    <div class="form-group">
        <label for="email">Confrim Email</label>
        <input type="email" value="<?php echo isset($email_conf) ? $email_conf : ''; ?>" class="form-control" name="email_confirm" placeholder="Confirm your email address:" >
    </div>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input value= "<?php echo $user_image ?>" type="file" class="form-control" name="user_image">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="password" placeholder="Edit your password:" >
    </div>
    <div class="form-group">
        <label for="password">Confirm Password</label>
        <input type="password" value="<?php echo isset($pword_conf) ? $pword_conf : ''; ?>" class="form-control" name="password_confirm" placeholder="Confirm your password:">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Update Profile">
    </div>
</form>

