<?php
// Check if the delete parameter is set in the URL
if (isset($_GET['search_delete'])) {
    try {
        // Sanitize the input to prevent SQL injections
        $search_delete_post_id = filter_var($_GET['search_delete'], FILTER_SANITIZE_NUMBER_INT);

        // Retrieve the post information
        $stmt = $cms_pdo->prepare("SELECT post_head FROM posts WHERE post_id = ?");
        $stmt->bindParam(1, $search_delete_post_id, PDO::PARAM_INT);
        $stmt->execute();
        $post_delete = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare the DELETE statement for removing the post from the main posts table
        $stmt = $cms_pdo->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->bindParam(1, $search_delete_post_id, PDO::PARAM_INT);
        $stmt->execute();

        // Set a success message in a session variable
        $_SESSION['success_message'] = "Your post '{$post_delete['post_head']}' has been successfully deleted.";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
}
?>



