<?php 
if (isset($_GET['del_com_per_post'])) {
    // Get the post ID from the URL parameter
    $unique_com_post = $_GET['unique_com_post'];

    try {
        // Sanitize the input to precent SQL injections
        $del_com_per_post =  filter_var($_GET['del_com_per_post'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("DELETE FROM comments WHERE comment_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $del_com_per_post, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Update the post_comment_count each time a comment is deleted
        $sql = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = :post_id";
        $stmnt = $cms_pdo->prepare($sql);
        $stmnt->execute([':post_id' => $unique_com_post]);

        // Retrieve the post information
        $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->bindParam(1, $unique_com_post, PDO::PARAM_INT);
        $stmt->execute();
        $post_del = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set a success message in a session variable
        $_SESSION['success_mess_del'] = "The comment from post '{$post_del['post_head']}' has been successfully deleted";

        // Creating a refresh statement to redirect to the same page again with the success message as a query parameter
        header("Location: ./admin_com_per_post.php?unique_com_post=" . $unique_com_post);

        // Exit the script after redirecting
        exit();

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 
}
// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_mess_del'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_mess_del']}</div>";
    unset($_SESSION['success_mess_del']);
}
?>