<?php 
if (isset($_GET['delete_users'])) {
    // Get the post ID from the URL parameter
    $get_users_id = $_GET['get_users_id'];

    try {
        // Sanitize the input to precent SQL injections
        $delete_comment_id =  filter_var($_GET['delete_users'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("DELETE FROM users WHERE user_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $delete_comment_id, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Creating a refresh statement so redirect to the same page again
        header("Location: ./admin_users.php?");

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 
}

?>