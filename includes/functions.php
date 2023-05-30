<?php
    function ifItIsMethod($method = null) {
        if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
            return true;
        }

        return false;
    }

    // Checking the seession in various scenarios if the user is logged in
    function checkIfIsLogged($check = '') {
        if (isset($_SESSION[$check])) {
            return true;
        }
        return false;
    }

    // That fucntion will return the header re-direction location
    function redirect_index($loc) {
        header("Location: {$loc}");
    }

    // Setting up the messages based on colour
    function set_msg($msg, $class = '') {
        if(empty($msg)) {
            unset($_SESSION['message']);
        } elseif ($class == 'green_color') {
            $_SESSION['message'] = "<div class='green_color {$class}'><span>{$msg}</span></div>";
        } else {
            $class == 'red_color'; 
            $_SESSION['message'] = "<div class='red_color {$class}'><span>{$msg}</span></div>";
        }
    }

    // Show message function to the HTML client side page based on colour you picked-up
    function show_msg($class = '') {
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    }

    // That function will retrun encode token for encryption "Is not recommened"
    function generate_token() {
        return md5(microtime().mt_rand());
    }

    // Send email to user 
    function send_email($to, $subject, $body, $from, $reply) {
        $headers =  "From: {$from} ". "\r\n" .
                    "Reply-To: {$reply}" . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
        if ($_SERVER['SERVER_NAME' != "localhost"]) {
            mail($to, $subject, $body, $headers);
        } else {
            echo "<hr><p>To:{$to}</p><p>Subject:{$subject}</p><p>{$body}</p><p>".$headers."</p><hr>"; 
        }            
    }

    // That function will check SQL database
    function count_field_val($cms_pdo, $tbl, $fld, $val) {
        try{
            $sql = "SELECT {$fld} FROM {$tbl} WHERE {$fld} = :value";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['value' => $val]);
            return $stmnt->rowCount();
        } catch (PDOException $e){
            echo "Error, the count field val is not found ". $e->getMessage();
            return false;
        }
    }

    // Validation code
    function get_validationcode($cms_pdo, $email) {
        try{
            $stmnt=$cms_pdo->prepare("SELECT validationcode FROM users WHERE email=:email");
            $stmnt->execute([':email' => $email]);
            $row = $stmnt->fetch();
            return $row['validationcode'];
        } catch (PDOException $e){
            return $e->getMessage();
        }
    }

    // That function will check the first row in database and return if the arguemnt exists or not
    function return_field_data($cms_pdo, $tbl, $fld, $val) {
        try{
            $sql = "SELECT * FROM {$tbl} WHERE {$fld} = :value";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['value' => $val]);
            return $stmnt->fetch();
        } catch (PDOException $e){
            return $e->getMessage();
        }
    }

    // That function will check the username in database if exists or not
    function check_username_exists($cms_pdo, $username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['username' => $username]);
            return $stmnt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Login function checking for cookie on email session
    function logged_in() {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            if (isset($_COOKIE['email'])) {
                $_SESSION['email'] = $_COOKIE["email"];
                return true;
            } else {
                return false;
            }
        }
    }
?>    
