<?php include "../../includes/database.php"; ?>
<?php include "admin_includes/admin_header.php"; ?>
<?php include "admin_includes/admin_functions.php"; ?>

<!-- HTML code for the categories page -->
<div id="wrapper">

<!-- Navigation menu -->
<?php include "admin_includes/admin_nav.php"; ?>

<!-- Page content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Admin Categories
                    <small><?php  
                        if(isset($_SESSION['username'])) {
                            echo $_SESSION['username'];
                        }?></small>
                </h1>
                    
                <!-- Create a form to add a new category -->
                <div class="col-md-3">

                <!-- Adding Categories to the database -->
                <?php include "admin_categories/admin_add_cat.php"; ?>  
                    <form action="" method="post">
                        <label for="cat_title">Add Category</label>
                        <div class="form-group">
                            <input class="form-control" type="text" name="cat_title">
                            <input type="hidden" name="cat_id" value="0">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-success" type="submit" name="add_categories" value="Add">
                        </div>
                    </form>

                    <!-- Edit & Update Categories into the database -->
                    <?php include "admin_categories/admin_edit_cat.php"; ?>
                    <?php include "admin_categories/admin_up_cat.php"; ?>
                    <form action="" method="post">
                    <label for="cat_title">Edit Category</label>
                    <div class="form-group">
                        <input value="<?php if(isset($edit_cat['cat_title'])) echo $edit_cat['cat_title']; ?>" class="form-control" type="text" name="cat_title" id="cat_title">
                        <input type="hidden" name="cat_id" value="<?php if(isset($edit_cat['cat_id'])) echo $edit_cat['cat_id']; ?>">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-warning" type="submit" name="update_categories" value="Update">
                        <button type="button" class="btn btn-primary" onclick="clearCatTitle()">Clear</button>
                    </div>
                    </form>
                    </div>

                    <!-- Display the categories in a table adding scroll down -->
                    <div class="col-md-9">
                    <div class="table-container" style="height: 400px; overflow-y: scroll;">
                    <!-- Creating the table -->
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category Title</th>
                                <th>Delete Categories</th>
                                <th>Edit Categories</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Getting all the categories in the table
                            // From database, checking the table categories and the column cat_title cat_id and returning the values
                            $admin_cat = admin_categories($cms_pdo);
                            if ($admin_cat !== false && count($admin_cat) > 0) {
                                foreach ($admin_cat as $cat_admin) {
                                echo "<tr>";
                                echo "<td>{$cat_admin['cat_id']}</td>";
                                echo "<td>{$cat_admin['cat_title']}</td>";
                                echo "<td><a href='admin_categories.php?delete={$cat_admin['cat_id']}' onclick=\"return confirm('Are you sure you want to delete the \'{$cat_admin['cat_title']}\' category ?')\">Delete</a></td>";
                                echo "<td><a href='admin_categories.php?edit={$cat_admin['cat_id']}'>Edit</a></td>";
                                echo "</tr>";
                                } 
                            }
                            ?>
                            <?php 
                            // Include delete categories
                            include "admin_categories/admin_del_cat.php"; 
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php include "admin_includes/admin_footer.php"; ?>
