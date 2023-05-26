<!-- Creating the table for view -->
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Comment Post id</th>
                <th>Author</th>
                <th>Email</th>
                <th>Status</th>
                <th>Days</th>
                <th>Comments</th>
                <th>In Response to Posts</th>
                <th>Post Image</th>
                <th>Approved</th>
                <th>Unapproved</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php include "admin_db_com_per_post.php"; ?> 
            <?php include "admin_appr_com_per_post.php"; ?>
            <?php include "admin_un_com_per_post.php"; ?>
            <?php include "admin_del_com_per_post.php"; ?>
        </tbody>
    </table>
</div>
