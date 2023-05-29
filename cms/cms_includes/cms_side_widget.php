<!-- Side Widget Well -->
<div class="well">
    <h4></h4>
    <?php
    // Check the check_posts function to return the posts table
    if (isset($_GET['get_posts_id']) && !empty($_GET['get_posts_id'])) {
        $get_posts_id = $_GET['get_posts_id'];
            echo "<a href='cms_edit_posts.php?get_posts_id=$get_posts_id' class='btn btn-warning'>Edit post</a>";
        } else {
            // User is on the index page, display "Create new post" button
            echo "<a href='cms_add_posts.php' class='btn btn-primary'>Create new post</a>";
        } 
?>
</div>

