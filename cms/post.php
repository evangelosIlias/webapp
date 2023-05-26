<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>
<?php include "cms_includes/cms_check_activity.php"; ?>

<?php 
// Set the cache control header
header("Cache-Control: max-age=3600"); ?>

<!-- Page Content -->
<div class="container">
<div class="row">

<!-- Blog posts starts here-->
<?php include "cms_includes/cms_nav.php"; ?>
<div class="col-md-8" style="margin-top: 60px;">
    <?php
    // Define the variable with a default value of null outside the if statement
    $get_posts_id = null; 

    // Checking if the GET parameter exists and is not empty
    if (isset($_GET['get_posts_id']) && !empty($_GET['get_posts_id'])) {
            // Creating a get_post_id variable to check if the post_id exists in the database
            $get_posts_id = $_GET['get_posts_id'];
            
            // Count the number of posts have been viewed  
            $count_the_post_views= post_views_count($cms_pdo, $get_posts_id);

    // Open connection with database and checking the posts table creating a loop and returning the values
    // Echo all the posts from database table based on different elements in the form below
    $return_post_id = check_post_id($cms_pdo, $get_posts_id);
    if (($return_post_id)) {
        foreach ($return_post_id as $all_posts) {
        ?>
        <h1 class="page-header">
            <?php echo $all_posts['post_head']?>
        </h1>
        <!-- First Blog Post -->
        <h2>
            <!-- Adding the GET request to unique post_id on post_title loop throug and recieved each post by unique id -->
            <a href="#"><?php echo $all_posts['post_title'] ?></a>
                </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $all_posts['post_author']; ?></a>
                            </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $all_posts['post_date']; ?></p>
                            <hr>
                        <img class="img-responsive" src="../cms/admin/admin_upload_images/<?php echo $all_posts['post_image']?>" alt="" width="300" style="height: 150 !important;">
                    <hr>
                <p><?php echo $all_posts['post_content']; ?></p>
            <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->
        <hr>
    <!-- This is the end of loop from php above including the HTML form and echo the columns -->
   <?php 
   }
}

} else {
    // If the GET parameter is not set or empty, you can redirect the user to an error page, or display an error message
    echo "Error: post id not specified.";
    exit();
} 
?>

<!-- The comment sections starts here -->
<?php include "admin/admin_comments/admin_add_comments.php"; ?>

<!-- Comments Form starts here -->
<div class="well">
    <h4>Leave a Comment:</h4>
    <form action="" method="post" role="form">
        <div class="form-group">
            <input type="hidden" name='user_id' value="<?= $user_id ?>">
            <textarea class="form-control" name="comment_content"  rows="3"></textarea>
        </div>
        <button type="submit" name="create_comment" class="btn btn-primary" name="comment_content">Submit comment</button>
    </form>
</div>
<hr>
<!-- The comment sections ends here -->

<!-- Posted Comments starts here to add the comments into the post -->
<?php include "admin/admin_comments/admin_post_comments.php"; ?>

<!-- Blog posts end here -->
</div>
<!-- Blog posts end here -->

<!-- Blog Sidebar Widgets Column starts here -->
<?php include "cms_includes/cms_sidebar.php"; ?>

</div>
<!-- /.row -->
<hr>

<!-- Script Connection -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>

<!-- Scroll Reaveal --> 
<script src="https://unpkg.com/scrollreveal"></script>

<!-- JS connection --> 
<script src="js/index.js"></script>

<?php include "cms_includes/cms_footer.php";?> 
