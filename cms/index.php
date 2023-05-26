<?php include "../includes/database.php"; ?>
<?php include "cms_includes/cms_header.php"; ?>
<?php include "cms_includes/cms_functions.php"; ?>
<?php include "cms_includes/cms_check_activity.php"; UserCountActivity($cms_pdo); ?>

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
// Checking the page with GET request if exists and if not will add 1 as default page / below is the page get request
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Total number of posts per page
$postsPerPage = 5;

// Calculate the offset based on the current page number
$pageOffset = ($page - 1) * $postsPerPage;

// Open a connection to the database and retrieve the total number of posts
$totalPosts = count(check_posts($cms_pdo));

// Calculate the total number of pages
$totalPages = ceil($totalPosts / $postsPerPage);

// Open connection with the database and retrieve the posts for the current page
$posts = check_posts_status($cms_pdo, $pageOffset, $postsPerPage);

// Echo all the posts from database table based on different elements in the form below
// Display the posts
if (empty($posts)) {
    echo "Oops, no more posts are available or the status of posts are draft";
} else {
    foreach ($posts as $all_posts) {
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
        <?php
    }
}
?>

</div>

<!-- Blog Sidebar Widgets Column -->
<?php include "cms_includes/cms_sidebar.php"; ?>

</div>
<!-- /.row -->
<hr>

<!-- Pagination pager -->
<ul class="pager">
    <?php
    // Display previous link
    if ($page > 1) {
        ?>
        <li>
            <a href="index.php?page=<?php echo $page - 1; ?>">Previous</a>
        </li>
        <?php
    }

    // Display pagination links
    if ($totalPages > 1) {
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? "active" : "";
            ?>
            <li class="<?php echo $activeClass; ?>">
                <a href="index.php?page=<?php echo $i; ?>" style="font-size: 18px;"><?php echo $i; ?></a>
            </li>
            <?php
        }
    }

    // Display next link
    if ($page < $totalPages) {
        ?>
        <li>
            <a href="index.php?page=<?php echo $page + 1; ?>">Next</a>
        </li>
        <?php
    }
    ?>
</ul>


<!-- Script Connection -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>

<!-- Scroll Reaveal --> 
<script src="https://unpkg.com/scrollreveal"></script>

<!-- Footer -->
<?php include "cms_includes/cms_footer.php";?>        
