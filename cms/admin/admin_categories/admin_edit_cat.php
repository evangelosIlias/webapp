<?php 
// Check if the edit parameter is set in the URL
if(isset($_GET['edit'])) {
    try {
        // Get the edit parameter
        $cat_id = $_GET['edit'];

        // Sanitize the input to prevent SQL injections
        $cat_id = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT);

        // Prepare the SELECT statement using a prepared statement
        $stmt = $cms_pdo->prepare("SELECT * FROM categories WHERE cat_id = :cat_id");
        $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->execute([':cat_id' => $cat_id]);
        $edit_cat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $edit_cat;
        
        // Remove the value from the input field
        unset($edit_cat['cat_title']);
    } catch (PDOException $e) {
        echo "Error can't edit this value: ".$e->getMessage();
    }
}
?>




