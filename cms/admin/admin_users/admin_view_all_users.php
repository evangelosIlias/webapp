<!-- Creating the table for view -->
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>User Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Last Login</th>
                <th>Active</th>
                <th>Username</th>
                <th>User Image</th>
                <th>User Role</th>
                <th>Admin</th>
                <th>Subscriber</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php include "admin_db_return_users.php"; ?>
            <?php include "admin_change_to_admin.php"; ?>
            <?php include "admin_change_to_sub.php"; ?>
            <?php include "admin_del_users.php"; ?>
        </tbody>
    </table>
</div>
