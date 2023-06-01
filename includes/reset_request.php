<?php
session_start();

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

include "./database.php";
include "./reset_header.php";
include "./functions.php"; 

// Initializing the error with an empty array
$errors = array();

if (!isset($_GET["vcode"])) {
    exit("Oops seems something went wrong, can't find the page you're looking for");
}

$vcode = $_GET["vcode"];
try {
    $sql = "SELECT * FROM users WHERE validationcode = :vcode";
    $stmt = $cms_pdo->prepare($sql);
    $stmt->bindValue(':vcode', $vcode, PDO::PARAM_STR);
    $stmt->execute();
    $result_req = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    if ($result_req) {
        // Get the user's email
        $email = $result_req['email'];

        // Retrieve and sanitize the new password
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password_confirm = filter_var($_POST['password_confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Check if the password and confirmation match
        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match";
        }

        // Giving an error if not all the fields are filled on the form
        if(empty($password) || empty($password_confirm)) {
            $errors[] = "Please fill in all the required fields";   
        } else {
            // Check if the validation code and password match
            if ($result_req['validationcode'] === $vcode) {
                // Additional password complexity checks can be added here if needed

                // Hash the new password
                $newPassword = password_hash($password, PASSWORD_BCRYPT);

                // Update the password in the database
                $updateStmt = $cms_pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
                $updateStmt->bindValue(':password', $newPassword, PDO::PARAM_STR);
                $updateStmt->bindValue(':email', $email, PDO::PARAM_STR);
                $updateStmt->execute();

                // Set a success message in a session variable
                $_SESSION['success_reset_request'] = "Your password has been updated successfully";

            } else {
                $errors[] = "Invalid password";
            }
        }
    } else {
        $errors[] = "Invalid validation code";
    }    
}
?>

<!-- The main container for the reset password area -->
<div class="reset_request_container">
    <h4>Update your password</h4>

    <!-- Display success message if available -->
    <?php if (isset($_SESSION['success_reset_request'])) : ?>
        <div class='alert alert-success'>
            <?php echo $_SESSION['success_reset_request']; ?><br>
            Please visit the <a href="login.php">login area</a> to log in.
        </div>
        <?php unset($_SESSION['success_reset_request']); ?>
    <?php endif; ?>

    <!-- Display errors if available -->
    <?php if (!empty($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
            <div class='alert alert-danger'><?php echo $error; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Creating a form -->
    <form action="" method="post">
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="New Password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_confirm" placeholder="Confirm New Password">
        </div>
        <div class="form-group">
            <input type="submit" class="reset_password" value="Update Password" name="submit">
        </div>
    </form>
</div>
