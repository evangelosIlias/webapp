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



<!-- Check status if logged in return the username of user -->
<div class="well"> 
    <div class="row">
        <div class="col-lg-12">
                <h4>Welcome <?php echo $_SESSION['username']; ?></h4>
                <div style="text-align: left; margin-top: 20px;">
                    <a href="../includes/logout.php" class="btnlogout">Logout</a>
                </div>
            <?php if (isset($_SESSION) && !empty($_SESSION)) {
                $email = $_SESSION['email'];
                $username = $_SESSION['username'];
                $user_role = $_SESSION['user_role'];
        
                if (isset($user_role) && $user_role === 'admin') {
                echo "<li><a href='admin'>Admin</a></li>";
                }
            } else {
                echo "Oops, you are not logged in";
            } ?> 
        </div>
    </div>
</div