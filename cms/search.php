<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>

<!-- Page Content -->
<div class="container">
<div class="row">

<!-- Blog Entries Column -->
<?php include "cms_includes/cms_nav.php"; ?>
<div class="col-md-8" style="margin-top: 60px;">
    <?php
    // Checking if the search is set and opening connection with database for the search tags
    // After we creating individual search with specific tags and return only the post based on specific tags from database
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $return_search = search_wildcard($cms_pdo, $search);
        if (!empty($return_search)) {
            foreach ($return_search as $search_returned) {   
            ?>
            <h1 class="page-header">
                <?php echo $search_returned['post_head'] ?>
            </h1>
            <!-- First Blog Post -->
            <h2>
            <a href="post.php?get_posts_id=<?php echo $search_returned['post_id']; ?>"><?php echo $search_returned['post_title']; ?></a>
            </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $search_returned['post_author'] ?></a>
                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span> <?php echo $search_returned['post_date'] ?>
                </p>
                <hr>
                    <a href="post.php?get_posts_id=<?php echo $search_returned['post_id']; ?>">
                        <img class="img-responsive" src="../cms/admin/admin_upload_images/<?php echo $search_returned['post_image']?>" alt="" width="300" style="height: 150 !important;">
                    </a>
                <hr>
                <p>
                    <?php echo $search_returned['post_content'] ?>
                </p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php
            }
            } else {
            echo "<h2> No results were found for '$search'
                  <h3> Hit the Blog to return to the main posts or try a different keyword </h3>
                  </h2>";
                }
        } else {
        // Adding the html posts into the loop and return the posts array
        // if there is no individual search then will return all the form with all posts
        $posts = check_posts($cms_pdo);
        if ($posts !== false && count($posts) > 0) {
            foreach ($posts as $all_posts) {
            ?>
            <h1 class="page-header">
                <?php echo $all_posts['post_head'] ?>
            </h1>
            <!-- First Blog Post -->
            <h2>
                <a href="#"><?php echo $all_posts['post_title'] ?></a>
            </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $all_posts['post_author'] ?></a>
                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span> <?php echo $all_posts['post_date'] ?>
                </p>
            <hr>
                <img class="img-responsive" src="../cms/images/<?php echo $all_posts['post_image'] ?>" alt="" width="900" height="200">
            <hr>
            <p>
                <?php echo $all_posts['post_content'] ?>
            </p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php
            }
        }
    }
    ?>
    
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

<?php include "cms_includes/cms_footer.php"; ?>
