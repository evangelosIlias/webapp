<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">

<!-- Navbar -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Blog</a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
        <li>
            <a href="../includes/index.php">Home</a>
        </li>
        <li>
            <a href="../map_index/index.php">Map</a>
        </li>
        <li>
            <a href="../includes/contact.php">Contact</a>
        </li>
        <?php
    // Checking if the user is logged in and if user_role is admin or not
    if (cms_check_logged_status()) {
      if (isset($_SESSION) && !empty($_SESSION)) {
        $email = $_SESSION['email'];
        $username = $_SESSION['username'];
        $user_role = $_SESSION['user_role'];

        if (isset($user_role) && $user_role === 'admin') {
          echo "<li><a href='admin'>Admin</a></li>";
        }
      }
    }
    ?>
    </ul>
   
</div> 

<!-- /.navbar-collapse -->
</div>

<!-- /.container -->
</nav>