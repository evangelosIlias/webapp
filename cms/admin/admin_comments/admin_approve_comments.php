<?php 
// Check if the delete parameter is set in the URL
if (isset($_GET['approved_comment'])) {
    try {
        // Sanitize the input to precent SQL injections
        $approve_comment_id =  filter_var($_GET['approved_comment'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("UPDATE comments SET comment_status = 'approved' WHERE comment_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $approve_comment_id, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Creating a refresh statement so redirect to the same page again
        header("Location: ./admin_comments.php");

    } catch (PDOException $e) {
        echo "Error can not approve this comment: ".$e->getMessage();
    } 
} 
?>