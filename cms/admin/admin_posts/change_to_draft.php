<?php 
// Check if the delete parameter is set in the URL
if (isset($_GET['change_to_draft'])) {
    try {
        // Sanitize the input to precent SQL injections
        $change_to_draft =  filter_var($_GET['change_to_draft'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("UPDATE posts SET post_status = 'draft' WHERE post_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $change_to_draft, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Creating a refresh statement so redirect to the same page again
        header("Location: ./admin_posts.php?");

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 
} 
?>