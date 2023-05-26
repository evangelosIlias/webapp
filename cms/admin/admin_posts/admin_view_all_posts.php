<div class="mt-2">
    <form action="./admin_search_posts.php" method="post" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" name="admin_search_posts" placeholder="Search posts...">
        <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
    </form>
</div>

<!-- Creating the table for view -->
<div style="margin-top: 20px;">
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Head</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Days</th>
                <th>Content</th>
                <th>Views</th>
                <th>View post</th>
                <th>Published</th>
                <th>Draft</th>
                <th>Delete</th>
                <th>Edit</th>
                
            </tr>
        </thead>
        <tbody>
            <?php include "admin_db_return_posts.php"; ?>
            <?php include "change_to_published.php"; ?>
            <?php include "change_to_draft.php"; ?>
            <?php include "admin_del_posts.php"; ?>
        </tbody>
    </table>
</div>
</div>