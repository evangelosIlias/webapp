<?php
// Get request these values from Server twice to avoid warning as a key => value pair
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    // Initialize the error empty array
    $error = array();
    
    // Initialize the variables with superglobal and HTML form
    $email = strtolower($_POST['email']);
    $pword = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Giving an error if not all the fields are filled on the form
    if(empty($email) || empty($pword) || empty($remember)) {
        $error[] = "Please fill in all the required fields and check the agree box";   
    } else {
        // Creating a connection and checking for email if is in database
        $user_cred = return_field_data($cms_pdo, "users", "email", $email);
    
        // Veryfing the password for user with the registered email
        if ($user_cred && password_verify($pword, $user_cred['password'])) {

            // Login message if the user successfully login
            set_msg("Welcome {$user_cred['username']}", "green_color");
            $_SESSION["firstname"] = $user_cred["firstname"];
            $_SESSION["lastname"] = $user_cred["lastname"];
            $_SESSION["email"] = $user_cred["email"];
            $_SESSION["username"] = $user_cred["username"];
            $_SESSION["user_role"] = $user_cred["user_role"];
            $_SESSION["joined"] = $user_cred["joined"];

            // Set a cookie with the session data
            setcookie("email", $user_cred["email"], time() + 3600 * 24 * 30, "/", "", true, true);
            
        } else {
            $error[] = "Email or password are not correct, try to login again or register if you dont have an account";
        }
    }
} else {
    // If the login fails the credentials stays as it is in the form box
    $email = "";
    $pword = "";
} 

// Display the error messages do the window
if (!empty($error)) {
    foreach($error as $msg){
        echo "<div class='alert alert-danger'>{$msg}</div>";
    }
}
?>




