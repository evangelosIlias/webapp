<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_nav.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>

<?php 
// Creating empty variables for the Form Creation to avoid the warning
$post_head = "";
$post_title = "";
$post_category_id = "";
$post_author = "";
$post_status = "";
$post_image = "";
$post_tags = "";
$post_content = "";
$post_date = "";
$post_comment_count = 0;

// Initialiazing the error with an empty array 
$error = array();

// Get the values from HTML form and request these values from Server
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') { 
    $post_head = filter_var($_POST['post_head'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_title = filter_var($_POST['post_title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_category_id = filter_var($_POST['post_category_id'], FILTER_SANITIZE_NUMBER_INT);
    $post_author = filter_var($_POST['post_author'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_status = filter_var($_POST['post_status'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = filter_var($_POST['post_tags'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_content = filter_var($_POST['post_content'], FILTER_SANITIZE_SPECIAL_CHARS);
    $post_date = date('Y-m-d');
    $post_comment_count = 0;

    // Define allowed file types
    $cms_allowed_types = ["image/jpeg", "image/jpg", "image/png", "image/gif", "image/pdf", "image/eps"];

    // Define maximum file size in bytes (5 MB)
    $max_size = 5242880;

    if (empty($post_image)) {
        // Image is not uploaded
        $error[] = "Please choose an image to upload";
    } elseif (!in_array($_FILES['image']['type'], $cms_allowed_types)) {
        // Invalid file type
        $error[] = "Invalid image file type. Please upload a valid image file 'jpg' 'png', 'jpeg', 'gif', 'pdf', 'eps'";
    } elseif ($_FILES['image']['size'] > $max_size) {
        // File size is too large
        $error[] = "File size exceeds the maximum limit of 5 MB";
    } else {
        // Upload the file to server
        $cms_dir = "admin/admin_upload_images/$post_image";
        move_uploaded_file($post_image_temp, $cms_dir);
    }

    // Checking if the post exists
    if (check_post_duplicate($cms_pdo, "posts", "post_title", ucfirst($post_title)) != 0) {
        $error[] = "Seems the post '{$post_head}' already exists";
    }
    // Giving an error message if the fields are not filled 
    if (empty($post_head)
        ||empty($post_title) 
        || empty($post_author)
        || empty($post_tags)
        ) {
            $error[] = "Please fill the 'Post Head', 'Post Title', 'Post Author' and 'Post Tags' fields";
        } else {
            if (empty($error)) {
            try {
                // Preparing the SQL to insert the values into the table
                $sql = "INSERT INTO posts (post_head, post_title, post_category_id, post_author, post_status, post_image, post_tags, post_content, post_date, post_comment_count) 
                VALUES (:post_head, :post_title, :post_category_id, :post_author, :post_status, :post_image, :post_tags, :post_content, :post_date, :post_comment_count )";
                
                // Prepare the query with PDOStatement
                $stmt = $cms_pdo->prepare($sql);

                // Creating a new array with placeholders
                $post_data = [
                    ':post_head' => ucfirst(strtolower($post_head)),
                    ':post_title' => ucfirst(strtolower($post_title)),
                    ':post_category_id' => $post_category_id,
                    ':post_author' => ucfirst(strtolower($post_author)),
                    ':post_status' => strtolower($post_status),
                    ':post_image' => $post_image,
                    ':post_tags' => strtolower($post_tags),
                    ':post_content' => ucfirst(strtolower($post_content)),
                    ':post_date' => $post_date,
                    ':post_comment_count' => $post_comment_count,
                ];

                // Execute the PDO statement 
                $stmt->execute($post_data);

                // Set a success message in a session variable
                $_SESSION['success_message'] = "Your post '{$post_head}' has successfully created. Please <a href='index.php'>View All Posts page</a></div>";

                } catch (PDOException $e) {
                    echo "Error can not insert values into posts: " . $e->getMessage();
                }
            }
        }
} // If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
    unset($_SESSION['success_message']);
} 

if (!empty($error)) {
    echo "<div class='alert alert-danger' style='text-align: center; width: 60%; margin: 0 auto;'>";
    foreach($error as $msg){
        echo "<p>{$msg}</p>";
    }
    echo "</div>";
}
?>
<!-- Creating new form for new posts -->
<form method="post" action="" enctype="multipart/form-data" style="width: 60%; margin: 0 auto; ">
<div style="text-align: center; font-family: 'Courgette';">
    <h1>Here you can create your post</h1>
</div>
    <div class="form-group">    
        <label for="post_head">Post Head</label>
        <input value= "<?php echo $post_head ?>" type="text" class="form-control" name="post_head" placeholder="Add your head of your post:">
    </div>
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value= "<?php echo $post_title ?>" type="text" class="form-control" name="post_title" placeholder="Add your title of your post:">
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category Id</label> 
        <p>Please pick up a category</p><br>
        <select name="post_category_id" id="post_category_id">
            <?php 
            $cms_cat = cms_categories($cms_pdo);
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
        <input value= "<?php echo $post_author ?>" type="text" class="form-control" name="post_author" placeholder="Your post author must be your username or your first and last name:">
    </div>
    <div class="form-group">
    <label for="post_status">Post Status</label>
    <p>Please pick up a status for post</p><br> 
    <select name="post_status">
    <option value="subscriber">Select Option</option>
        <option value="published" <?php echo ($post_status == 'published') ? 'selected' : ''; ?>>Published</option>
        <option value="draft" <?php echo ($post_status == 'draft') ? 'selected' : ''; ?>>Draft</option>
    </select>
    </div>
    <div class="form-group">
        <label for="img">Post Image</label>
        <input value= "<?php echo $post_image ?>" type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value= "<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags" placeholder="Add your tags to find your post in the search blog, fill free to add more than one tag and separated with a comma:">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea value= "<?php echo $post_content ?>"class="form-control" name="post_content" id="summernote" cols="30" rows="10" placeholder="Your content of your post goes here:"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Publish Post">
    </div>
</form>

<?php include "cms_includes/cms_footer.php";?>    
