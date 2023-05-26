<?php 
if (isset($_GET['delete_comment'])) {
    // Get the post ID from the URL parameter
    $get_posts_id = $_GET['get_posts_id'];

    try {
        // Sanitize the input to precent SQL injections
        $delete_comment_id =  filter_var($_GET['delete_comment'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("DELETE FROM comments WHERE comment_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $delete_comment_id, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Update the post_comment_count each time a comment is deleted
        $sql = "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = :post_id";
        $stmnt = $cms_pdo->prepare($sql);
        $stmnt->execute([':post_id' => $get_posts_id]);

        // Creating a refresh statement so redirect to the same page again
        header("Location: ./admin_comments.php");

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 
}

?>