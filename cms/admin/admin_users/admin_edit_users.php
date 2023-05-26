<?php 
// Creating empty variables for the Form Creation to avoid the warning
$fname = "";
$lname = "";
$username = "";
$email = "";
$email_conf = "";
$pword = "";
$pword_conf = "";

// Initialiazing the error with an empty array 
$error = array();

// If is set the GET method return the id_posts parameter
if(isset($_GET['id_users'])) {
    $id_users = $_GET['id_users'];
    $check_users_by_id = user_result_by_id($cms_pdo, $id_users);
   
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

            $error[] = "Please fill in the required fields below to edit a user";
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
                $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, password = :password, user_role = :user_role WHERE user_id = :user_id";

                // Preparing the sql
                $stmnt = $cms_pdo->prepare($sql);
                
                // Adding associative array with five key-value pairs
                $user_data = [
                    ':firstname' => ucfirst(strtolower($fname)),
                    ':lastname' => ucfirst(strtolower($lname)),
                    ':username' => strtolower($username),
                    ':email' => strtolower($email),
                    ':password' => password_hash($pword, PASSWORD_BCRYPT),
                    ':user_role' => strtolower($user_role),
                    ':user_id' => $id_users,
                ];
                
                // Execute the stmnt 
                $stmnt->execute($user_data);
                
                // Set a success message in a session variable
                $_SESSION['success_message'] = "The user'{$username}' has successfully created: <a href='./admin_users.php'>View All users here</a></div>";
               
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

 <!-- Edit form for posts -->
 <form method="post" action="" enctype="multipart/form-data">
 <div class="form-group">    
        <label for="firstname">First Name</label>
        <input type="text" value= "<?php echo $check_users_by_id['firstname']; ?>" class="form-control" name="firstname" placeholder="Edit your first name:">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" value= "<?php echo $check_users_by_id['lastname']; ?>" class="form-control" name="lastname" placeholder="Edit your last name:">
    </div>
    <div class="form-group">
        <label for="username">User Name</label>
        <input type="text" value= "<?php echo $check_users_by_id['username']; ?>" class="form-control" name="username" placeholder="Edit your username:">
    </div>
    <div class="form-group">
    <label for="user_role">User Role</label> 
        <select name="user_role" id="user_role">
            <?php $user_role = $check_users_by_id['user_role']; ?>
            <option value="admin" <?php echo ($user_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="subscriber" <?php echo ($user_role == 'subscriber') ? 'selected' : ''; ?>>Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" value= "<?php echo $check_users_by_id['email']; ?>" class="form-control" name="email" placeholder="Edit your email address:" >
    </div>
    <div class="form-group">
        <label for="email">Confrim Email</label>
        <input type="email" value="<?php echo isset($check_users_by_id['email_confirm']) ? $check_users_by_id['email_confirm'] : ''; ?>" class="form-control" name="email_confirm" placeholder="Confirm your email address:" >
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
        <input type="password" value="<?php echo isset($check_users_by_id['password_confirm']) ? $check_users_by_id['password_confirm'] : ''; ?>" class="form-control" name="password_confirm" placeholder="Confirm your password:">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Update User">
    </div>
<?php
}
?>
