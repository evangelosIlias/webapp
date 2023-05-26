<?php 
// Check if the delete parameter is set in the URL
if (isset($_GET['delete'])) {
    try {
        // Sanitize the input to precent SQL injections
        $delete_id =  filter_var($_GET['delete'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare the DELETE statemnet using a preared statement
        $stmt = $cms_pdo->prepare("DELETE FROM categories WHERE cat_id = ?");

        // Bind the parameter to the prepared statement
        $stmt->bindParam(1, $delete_id, PDO::PARAM_INT);

        // Execute the prepared statement
        $stmt->execute();

        // Creating a refresh statement so redirect to the same page again
        header("Location: admin_categories.php?");

    } catch (PDOException $e) {
        echo "Error can not delete these values: ".$e->getMessage();
    } 

} 
?>