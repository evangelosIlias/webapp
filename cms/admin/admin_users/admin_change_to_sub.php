<?php 
// Check if the delete parameter is set in the URL
if (isset($_GET['change_to_sub'])) {
    try {
        // Sanitize the input to precent SQL injections
        $change_to_sub =  filter_var($_GET['change_to_sub'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("UPDATE users SET user_role = 'subscriber' WHERE user_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $change_to_sub, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Creating a refresh statement so redirect to the same page again
        header("Location: ./admin_users.php?");

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 
} 
?>