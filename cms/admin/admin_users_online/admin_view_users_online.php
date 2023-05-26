<!-- Creating the table for view -->
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Username</th>
                <th>Joined</th>
                <th>Last Activity</th>
                <th>IP</th>
                <th>User Browser</th>
            </tr>
        </thead>
        <tbody>
            <?php include "admin_db_return_users_online.php"; ?>
        </tbody>
    </table>
</div>
