<?php include "../../includes/database.php"; ?>
<?php include "admin_includes/admin_header.php"; ?>
<?php include "admin_includes/admin_functions.php"; ?>

<!-- HTML code for the categories page -->
<div id="wrapper">

<!-- Navigation menu -->
<?php include "admin_includes/admin_nav.php"; ?>

<!-- Page content -->
<div id="page-wrapper" style="height: 850px; overflow: scroll;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Admin Post
                    <small><?php if(isset($_SESSION['username'])) { echo $_SESSION['username']; }?></small>
                </h1>
                    <?php include "admin_search/admin_view_all_search_posts.php"; ?>            
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- Admin footer -->
<?php include "admin_includes/admin_footer.php"; ?>