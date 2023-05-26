<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>

<?php 
// Set the cache control header
header("Cache-Control: max-age=3600"); ?>

<!-- Page Content -->
<div class="container">
<div class="row">

<!-- Blog Entries Column -->
<?php include "cms_includes/cms_nav.php"; ?>
<div class="col-md-8" style="margin-top: 60px;">
    <?php
    $get_blog_categories = null;
    if(isset($_GET['blog_categories'])) {
        $get_blog_categories = $_GET['blog_categories'];
    }
    // Open connection with database and checking the posts table creating a loop and returning the values
    // Echo all the posts from database table based on different elements in the form below
    $return_blog_categoies = check_categories_id($cms_pdo, $get_blog_categories);
    if (!empty($return_blog_categoies)) {
        foreach ($return_blog_categoies as $all_posts) { 
        ?>
        <h1 class="page-header">
            <?php echo $all_posts['post_head']?>
        </h1>
        <!-- First Blog Post -->
        <h2>
        <a href="post.php?get_posts_id=<?php echo $all_posts['post_id']; ?>"><?php echo $all_posts['post_title']; ?></a>
                </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $all_posts['post_author']?></a>
                            </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $all_posts['post_date']?></p>
                            <hr>
                            <a href="post.php?get_posts_id=<?php echo $all_posts['post_id']; ?>">
                                <img class="img-responsive" src="../cms/admin/admin_upload_images/<?php echo $all_posts['post_image']; ?>" alt="" width="300" style="height: 150;">
                            </a>
                    <hr>
                <p><?php echo $all_posts['post_content']?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        <hr>
    <!-- This is the end of loop from php above including the HTML form and echo the columns -->
   <?php }} ?>
</div>

<!-- Blog Sidebar Widgets Column -->
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
