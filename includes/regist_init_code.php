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

    // Get the values from HTML form and request these values from Server
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
        $lname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email_conf = filter_var($_POST['email_confirm'], FILTER_SANITIZE_EMAIL);
        $pword = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pword_conf = filter_var($_POST['password_confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //$agree = $_POST['agree'];
        
    // Giving an error if not all the fields are filled on the form
    if (empty($fname) 
        || empty($lname)
        || empty($username)
        || empty($email)
        || empty($email_conf)
        || empty($pword)
        || empty($pword_conf)) { 
        $error[] = "Please fill in the required fields below to register";
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
        if (check_username_exists($cms_pdo, $username)) {
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
        if (count_field_val($cms_pdo, "users", "email", $email) != 0) {
            $error[] = "Seems the user with e-mail: '{$email}' is already registered, try to login";
        }

        $agree = isset($_POST['agree']) ? $_POST['agree'] : '';
        if ($agree !== 'on') {
            $error[] = "Please agree the terms and conditions";
        }

        // Checking if there is no error the values will added to the DataBase
        if (empty($error)){
            $vcode = generate_token();
            try {
                $sql = "INSERT  INTO users (firstname, lastname, username,
                email, password, validationcode, 
                active, joined, last_login) VALUES (
                :firstname, 
                :lastname,
                :username,
                :email,
                :password,
                :vcode, 0, current_date, current_date
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
                ];
                // Execute the stmnt 
                $stmnt->execute($user_data);

                // message to the user
                set_msg("Welcome {$username}, you have successfully registered, please login to see your content", "green_color");
                $agree == "on";

                // keeping the values into the fields after error checking or refreshing
                $fname = '';
                $lname = '';
                $username = '';
                $email = '';
                $email_conf = '';
                $pword = '';
                $pword_conf = '';

                } catch(PDOException $e){
                     echo "Error, can't add these values in the form: ".$e->getMessage();
                }}} 
        } 
        if (!empty($error)) {
            foreach($error as $msg){
                echo "<div class='alert alert-danger'>{$msg}</div>";
            }
        }
?>