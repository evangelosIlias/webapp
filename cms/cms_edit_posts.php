<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_nav.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>

<?php 
// Initialiazing the error with an empty array 
$error = array();

if (isset($_GET['get_posts_id']) && !empty($_GET['get_posts_id'])) {

    $get_posts_id = $_GET['get_posts_id'];
    try {
        $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
        $stmt->bindParam(":post_id", $get_posts_id, PDO::PARAM_INT);
        $stmt->execute();
        $post_result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error with the post_result_by_id function: " . $e->getMessage();
    }

    // Checking if the name=submit is being set from HTML form 
    if (isset($_POST['submit'])) {
        $post_id = $_POST['post_id'];
        $post_head = $_POST['post_head'];
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date = date('Y-m-d H:i:s');

        // Get the uploaded file name and path
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        // Define allowed file types
        $allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/pdf", "image/eps"];

        // Define maximum file size in bytes (5 MB)
        $max_size = 5242880;

        // Checking the image type if allowed and the maxsize is set to 5MB
        if (empty($post_image)) {
            $error[] = "Please choose an image to upload.";
        } elseif (!in_array($_FILES['post_image']['type'], $allowed_types)) {
            $error[] = "Invalid image file type. Please upload a valid image file 'jpg' 'png', 'jpeg', 'gif', 'pdf', 'eps'";
        } elseif ($_FILES['post_image']['size'] > $max_size) {
            $error[] = "File size exceeds the maximum limit of 5 MB.";
        } else {
            // Upload the file to server
            $target_dir = "admin/admin_upload_images/$post_image";
            move_uploaded_file($post_image_temp, $target_dir);
        }
        
        // if there is no errors then updating the database
        if (empty($error)) {
            try {
                // Update the post in the database
                $sql = "UPDATE posts SET post_head = :post_head, post_title = :post_title, post_category_id = :post_category_id, post_author = :post_author, post_image = :post_image, post_tags = :post_tags, post_content = :post_content, post_date = :post_date WHERE post_id = :post_id";
                $stmt = $cms_pdo->prepare($sql);
                $stmt->execute(array(
                    ':post_head' => ucfirst(strtolower($post_head)),
                    ':post_title' => ucfirst(strtolower($post_title)),
                    ':post_category_id' => $post_category_id,
                    ':post_author' => ucfirst(strtolower($post_author)),
                    ':post_image' => $post_image,
                    ':post_tags' => strtolower($post_tags),
                    ':post_content' => ucfirst(strtolower($post_content)),
                    ':post_date' => $post_date,
                    ':post_id' => $get_posts_id
                ));
                
                // Set a success message in a session variable
                $_SESSION['success_message'] = "Your post '{$post_head}' has successfully updated. Please <a href='post.php?get_posts_id={$get_posts_id}'>View All Posts page</a></div>";
            
                // Redirect to the same page to display the message by refreshing the page
                header("Location: {$_SERVER['REQUEST_URI']}");
                exit;
                
            } catch (PDOException $e) {
                // Display an error message
                $error[] = "Error updating the posts" .  $e->getMessage();
            }
        }             
    } 

// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
unset($_SESSION['success_message']);
}

// Looping through the error messages and displaying if errors are encountered
if (!empty($error)) {
foreach($error as $msg){
    echo "<div class='alert alert-danger'>{$msg}</div>";
}
} 
?>
<!-- Edit form for posts -->
<form method="post" action="" enctype="multipart/form-data" style="width: 60%; margin: 0 auto;">
<div style="text-align: center; font-family: 'Courgette';">
    <h1>Here you can eidt your post</h1>
</div>
<div class="form-group">    
    <input type="hidden" name="post_id" value="<?php echo $post_result['post_id'] ?>">
</div>
<div class="form-group">    
    <label for="post_head">Post Head</label>
    <input value= "<?php echo $post_result['post_head']; ?>" type="text" class="form-control" name="post_head">
</div>
<div class="form-group">
    <label for="post_title">Post Title</label>
    <input value= "<?php echo $post_result['post_title']; ?>" type="text" class="form-control" name="post_title">
</div>
<div class="form-group">
    <label for="post_category_id">Post Category Id</label> 
    <p>Please pick up a category, if the category does not exist add a new category from the Categories</p><br>
    <select name="post_category_id" id="post_category">
        <?php 
        $cms_cat = get_categories($cms_pdo);
        if (!empty($cms_cat)) {
            foreach ($cms_cat as $cat_cms) {
                echo "<option value='" . $cat_cms['cat_id'] . "'>" . $cat_cms['cat_title'] . "</option>";
            }   
        }
        ?>
    </select>
</div>
<div class="form-group">
    <label for="post_author">Post Author</label>
    <input value= "<?php echo $post_result['post_author']; ?>" type="text" class="form-control" name="post_author">
</div>
<div class="form-group">
    <label for="post_status">Post Status</label>
    <p><?php echo $post_result['post_status']; ?></p>
</div>
<div class="form-group">
    <img width="200" height="150" src="admin/admin_upload_images/<?php echo $post_result['post_image']; ?>" alt="">
    <input class="form-control" type="file" name="post_image">
</div>
<div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value= "<?php echo $post_result['post_tags'] ?>" type="text" class="form-control" name="post_tags">
</div>
<div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo $post_result['post_content']; ?></textarea>
</div>
<div class="form-group">
    <input type="submit" class="btn btn-warning" name="submit" value="Update Post">
</div>
</form>
<?php
}
?>

<?php include "cms_includes/cms_footer.php";?>    

