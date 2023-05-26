<?php
// Request these values from Server
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Retrieve the category ID and new title from the form
    $cat_id = $_POST['cat_id'];
    $cat_title = $_POST['cat_title'];
    $cat_title = ucwords(strtolower($cat_title));

    // check if form has been submitted for updating category
    if(isset($_POST['update_categories'])) {

    // Giving an error if not all the fields are filled on the form
    if (empty($cat_title)) { 
        echo '<span style="color: red;">Please hit edit to select category title</span>';   
    } else {
        try {

            // Sanitize input to prevent SQL injection
            $cat_id = filter_var($cat_id, FILTER_SANITIZE_NUMBER_INT);
            $cat_title = filter_var($cat_title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if the category already exists
            $stmt = $cms_pdo->prepare("SELECT cat_title FROM categories WHERE cat_title = :cat_title AND cat_id != :cat_id");
            $stmt->bindParam(':cat_title', $cat_title, PDO::PARAM_STR);
            $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                echo '<span style="color: red;">The category \'' . $cat_title . '\' already exists</span>';
            } else {
                // Prepare and execute the UPDATE statement
                $stmt = $cms_pdo->prepare("UPDATE categories SET cat_title = :cat_title WHERE cat_id = :cat_id");
                $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
                $stmt->bindParam(':cat_title', $cat_title, PDO::PARAM_STR);
                $stmt->execute();
                echo '<div style="color: green;"> The category \''.$cat_title.'\' with ID: '.$cat_id.' was successfully Updated</div>';
                }
            } catch (PDOException $e) {
                echo "Error cant update this value: " . $e->getMessage();
            }        
        }

    }
}
?>
