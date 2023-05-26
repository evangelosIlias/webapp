<?php include "../cms_includes/cms_check_activity.php"; ?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">Admin Dashboard</a>
</div>

<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
<li><a href="./admin_users_online.php">Users Online: <?php echo UserCountActivity($cms_pdo); ?></a></li>
    <li><a href="../index.php">Blog Page</a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i> <?php if(isset($_SESSION['username'])) { echo $_SESSION['username'];} ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="admin_profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="admin_includes/admin_logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>
</ul>
</ul>

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
<ul class="nav navbar-nav side-nav">
    <!-- <li>                    
        <a href="admin_widgets.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
    </li> -->
    <li>
        <a href="admin_posts.php"><i class="fa fa-fw fa-table"></i> View All Posts</a>
    </li>
    <li>
        <a href="admin_posts.php?source=add_posts"><i class="fa fa-fw fa-table"></i> Add Post</a>
    </li>
    <li>
        <a href="admin_categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
    </li>
    <li class="">
        <a href="admin_comments.php"><i class="fa fa-comments"></i> Comments</a>
    </li>
    <li>
        <a href="admin_users.php"><i class="fa fa-users"></i> View All Users</a>
    </li>
    <li>
        <a href="admin_users.php?source=add_users"><i class="fa fa-user"></i> Add User</a>
    </li>
    <li>
    <li>
        <a href="admin_profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
    </li>
    <li>
        <a href="admin_users_online.php"><i class="fa fa-users"></i> Users Online</a>
    </li>
    </ul>
</div>
    <!-- /.navbar-collapse -->
</nav>
