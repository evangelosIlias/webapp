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
                    Admin Posts
                    <small><?php  if(isset($_SESSION['username'])) { echo $_SESSION['username']; }?></small>
                </h1>

                <!-- Creating a GET request for the add_post form -->
                <?php 
                $source = isset($_GET['source']) ? $_GET['source'] : '';
                switch($source) {
                        case 'add_posts';
                        include "admin_posts/admin_add_posts.php";
                        break;

                        case 'edit_posts';
                        include "admin_posts/admin_edit_posts.php";
                        break;

                        default:
                        include "admin_posts/admin_view_all_posts.php";
                        break;
                    }
                    ?>  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin footer -->
<?php include "admin_includes/admin_footer.php"; ?>