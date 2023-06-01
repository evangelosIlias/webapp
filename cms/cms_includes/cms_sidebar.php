<!-- Blog Side Bar Widget Column -->
<div class="col-md-4" style="margin-top: 100px;">
 
<!-- Check status if logged in return the username of user -->
<div class="well"> 
    <div class="row">
        <div class="col-lg-12">
                <h4><?php
                        if (isset($_SESSION) && !empty($_SESSION) && isset($_SESSION['username'])) {
                        echo "<h4>Welcome " . $_SESSION['username'] . "</h4>";
                        } else {
                        echo "<h4>Hi Guest</h4>";
                        }
                        ?></h4>
                <div style="text-align: left; margin-top: 20px;">
                    <a href="../includes/logout.php" class="btnlogout">Logout</a>
                    <?php
                        if (isset($_SESSION) && !empty($_SESSION)) {
                            if (isset($_SESSION['username']) && isset($_SESSION['user_role'])) {
                                $username = $_SESSION['username'];
                                $user_role = $_SESSION['user_role'];

                                if ($user_role === 'admin') {
                                    echo "<a href='admin' class='btnlogout'>Admin</a>";
                                } else {
                                    // Handle non-admin user case
                                }
                            } else {
                                // Handle missing username or user_role keys
                            }
                        } else {
                            echo "Oops, you are not logged in";
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>

<!-- Blog Search Well -->
<div class="well"> 
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
    <div class="input-group">
        <input name="search" type="text" class="form-control">
        <span class="input-group-btn">
            <button name="submit" class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
        </button>
    </span>
</div>
<!-- Form Search -->
</form> 

<!-- /.input-group -->
</div>

<!-- Blog Categories Well -->
<div class="well">

<h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            Categories <span class="caret"></span>
            </button>
                <div class="dropdown-menu" style="height: 200px; width: 100px; overflow: auto;">
                    <ul class="list-unstyled" style="margin-left: 10px;">
                    <?php
                    // From database, checking the table categories and the column cat_title and returning the values
                    if(isset($cms_pdo) && !empty($cms_pdo)) {
                        $sidebar_cat = get_categories($cms_pdo);
                    if (!empty($sidebar_cat)) {
                        foreach ($sidebar_cat as $cat_sidebar) {
                            echo "<li><a href='blog_categories.php?blog_categories={$cat_sidebar['cat_id']}'>{$cat_sidebar['cat_title']}</a></li>";
                            } 
                        } else {
                            echo "No categories found";
                        }
                    }
                    ?> 
                </ul>
            </div>
        </div>
    </div>
<!-- /.col-lg-6 -->
</div>

<!-- /.row -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add this CSS to drop-down menu -->
<style>
  .dropdown-menu a {
    color: #333;
    text-decoration: none;
  }
  .dropdown-menu a:hover {
    background-color: #f5f5f5;
  }
</style>

<?php include "cms_side_widget.php"; ?>

