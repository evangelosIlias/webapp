<?php 

// Initialiazing the error with an empty array 
$error = array();

// Request these values from Server
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') { 

    $cat_title = $_POST['cat_title'];

    // Convert the first letter of each word to uppercase and the rest to lowercase
    $cat_title = ucwords(strtolower($cat_title));

     // check if form has been submitted
     if(isset($_POST['add_categories'])) {

        // Giving an error if not all the fields are filled on the form
        if (empty($cat_title)) { 
            echo '<span style="color: red;">Please add category title</span>';    
        } else {
            // Checking if the category aready exists
            $sql_check = "SELECT cat_id FROM categories WHERE cat_title = :cat_title";
            $stmt_check = $cms_pdo->prepare($sql_check);
            $stmt_check->execute([':cat_title' => $cat_title]);
            $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                echo '<span style="color: red;">The category \'' . $cat_title . '\' already exists</span>';
            } else {
                try {
                    $sql = "INSERT INTO categories (cat_title) VALUES (:cat_title)";
                    // Preparing SQL
                    $stmt = $cms_pdo->prepare($sql);
                    // Creating an array to hold the values
                    $cat_data = [
                        ':cat_title' => $cat_title,
                    ];
                    // Executing the array
                    $stmt->execute($cat_data);
                    echo '<div style="color: green;"> The category with title \''.$cat_title.'\' was successfully added</div>';
                } catch(PDOException $e) {
                    echo "Error, can't add these values in the form: ".$e->getMessage();
                }
            }
        }
    }
}
?>