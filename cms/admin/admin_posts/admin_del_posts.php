<?php
// Check if the delete parameter is set in the URL
if (isset($_GET['delete'])) {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    try {
        // Sanitize the input to prevent SQL injections
        $delete_post_id = filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);

        // Retrieve the post_head before deleting the post
        $stmt = $cms_pdo->prepare("SELECT post_head FROM posts WHERE post_id = ?");
        $stmt->bindParam(1, $delete_post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare the DELETE statement using a prepared statement
        $stmt = $cms_pdo->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->bindParam(1, $delete_post_id, PDO::PARAM_INT);
        $stmt->execute();

        // Set a success message in a session variable
        $_SESSION['success_message'] = "The post '{$post['post_head']}' has been successfully deleted";

        // Creating a refresh statement to redirect to the same page again with the success message as a query parameter
        header("Location: ./admin_posts.php?success=1");

        // Exit the script after redirecting
        exit();
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
}
// If there is a success message in the session or as a query parameter, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
} elseif (isset($_GET['success']) && $_GET['success'] == 1) {
    // Display a generic success message if $post is not available
    echo "<div class='alert alert-success'>The post has been successfully deleted</div>";
}
?>


