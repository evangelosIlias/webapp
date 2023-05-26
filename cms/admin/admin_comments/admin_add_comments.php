<?php 
// Avoiding undefine variables 
$comment_content = "";
$user_id = "";
$user['firstname'] = "";
$user['lastname'] = "";

if(isset($cms_pdo) && !empty($cms_pdo)) { 

    // Double check if the user is already logged in
    function check_logged_in() {
        try {
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
        } catch (Exception $e) {
            echo "Error you are not logged in, please log in and try again: " . $e->getMessage();
            return false;
        }
    }

    // check if the user is logged in and if yes requesting values from users table to inserted into comments tables
    if (check_logged_in()) {
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmnt = $cms_pdo->prepare($sql);
        $stmnt->execute([':email' => $email]);
        $user = $stmnt->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['user_id'];
        $comment_email = $user['email'];
        $comment_author = $user['username'];
        //$comment_fullname = $user['firstname'] . ' ' . $user['lastname'];
    }

    // If is sset the POST superglobal taking the name from posts.php name="create_comment"
    if(isset($_POST['create_comment'])) { 

        // Getting the post id from GET superglobal coming from post.php page where checking if the psot exists in database
        $get_posts_id = $_GET['get_posts_id'];

        // Initialize the variables
        $comment_content = $_POST['comment_content'];
        $comment_date = date('Y-m-d H:i:s');

        // Insert the comment into the database
        try {
            $sql = "INSERT INTO comments (comment_post_id, comment_content, comment_status, comment_date, user_id, comment_email, comment_author)
                    VALUES (:get_posts_id, :comment_content, 'approved', :comment_date, :user_id, :comment_email, :comment_author)";
            $stmnt = $cms_pdo->prepare($sql);
            $comment_data = [
                ':get_posts_id' => $get_posts_id,
                ':comment_content' => ucfirst(strtolower($comment_content)),
                ':comment_date' => $comment_date,
                ':user_id' => $user_id,
                ':comment_email' => $comment_email,
                ':comment_author' => $comment_author
            ];
            // Execute the SQL statement
            $stmnt->execute($comment_data);

            // Update the post_comment_count each time comment added the database count the total comments
            $sql = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = :post_id";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute([':post_id' => $get_posts_id]);

            // Set a success message in a session variable
            $_SESSION['success_message'] = "Your comment was submitted successfully";

            // Redirect to the same page to display the message by refreshing the page
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit;

        } catch (PDOException $e) {
            echo "Error cant add values into the comments table: " . $e->getMessage();
        }
}
}
// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}

?>
