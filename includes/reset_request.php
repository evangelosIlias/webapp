<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

include "./database.php";
include "./reset_header.php";
include "./functions.php"; 

// Initializing the error with an empty array
$error = array();

if (!isset($_GET["vcode"])) {
    exit("Oops seems something went worng, cant find the page you looking for");
}

$vcode = $_GET["vcode"];
    try {
        $sql = "SELECT * FROM users WHERE validationcode = :vcode";
        $stmt = $cms_pdo->prepare($sql);
        $stmt->bindValue(':vcode', $vcode, PDO::PARAM_STR);
        $stmt->execute();
        $result_req = $stmt->fetch(PDO::FETCH_ASSOC);

        // if ($result_req) {
        //     // Get the user's email
        //     $email = $result_req['email'];
            
        //     // Checking the validation 
        //     $validationCode = $result_req['validationcode'];
        //     $password = $result_req['password'];

        //     // Check if the validation code and password match
        //     if ($validationCode === $result_req['validationcode']) {

        //         // Hash the new password
        //         $newPassword = password_hash($password, PASSWORD_BCRYPT);

        //         // Update the password in the database
        //         $updateStmt = $cms_pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        //         $updateStmt->bindValue(':password', $newPassword, PDO::PARAM_STR);
        //         $updateStmt->bindValue(':email', $email, PDO::PARAM_STR);
        //         $updateStmt->execute();

        //         // Set a success message in a session variable
        //         $_SESSION['success_request'] = "You password has been updated successfully";

        //     } else {
        //         $error[] = "The password is invalid. Please try again";
        //     }
        // } else {
        //     $error[] = "The password is same as the user email";
        // }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }

 // If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_request'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_request']}</div>";
    unset($_SESSION['success_request']);
}

if (!empty($error)) {
    foreach ($error as $msg) {
        echo "<div class='alert alert-danger'>{$msg}</div>";
    }
}   
?>

<!-- The main container for reset password area -->
<div class="reset_request_container">
    <h4>Update your password</h4>

<!--Creating a form -->    
<form action="" method="post">
    <div class="form-group">
        <input type="password" value= "<?php echo $pword?>" class="form-control" name="password" placeholder="New Password:" >
    </div>
    <div class="form-group">
        <input type="password" value= "<?php echo $pword_conf?>" class="form-control" name="password_confirm" placeholder="Confirm New Password:" >
    </div>
    <div class="form-group">
        <input type="submit" class="reset_password" value="Update Password" name="submit">
    </div>  
</form>
</div>