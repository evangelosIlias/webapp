<?php
// Check the check_posts function to return the posts table
if (isset($cms_pdo) && !empty($cms_pdo)) {
    try {
        $admin_posts = check_posts($cms_pdo);
        if (!empty($admin_posts)) {
            foreach ($admin_posts as $posts_admin) {
                echo "<tr>";
                echo "<td>{$posts_admin['post_id']}</td>";
                echo "<td>{$posts_admin['post_head']}</td>";
                echo "<td>{$posts_admin['post_author']}</td>";
                echo "<td><a href='../post.php?get_posts_id={$posts_admin['post_id']}'>{$posts_admin['post_title']}</a></td>";
                $categories = get_post_with_category_title($cms_pdo); // Checking both tables categories and posts and return the cat_title
                foreach ($categories as $category) { // Looping through
                    if ($category['cat_id'] == $posts_admin['post_category_id']) { // if cat_id and post_category_id are the same return the cat_title
                        $cat_title = $category['cat_title']; // new variable for cat_title
                    }
                }
                echo "<td>{$cat_title}</td>";
                echo "<td>{$posts_admin['post_status']}</td>";
                echo "<td><img src='./admin_upload_images/{$posts_admin['post_image']}' width='50px'heigth='50px' alt='image'></td>";
                echo "<td>{$posts_admin['post_tags']}</td>";
                //echo "<td><a href='./admin_comments.php?get_posts_id={$posts_admin['post_comment_count']}' class='btn btn-outline-info bg-info'>{$posts_admin['post_comment_count']}</a></td>";
                echo "<td><a href='./admin_com_per_post.php?unique_com_post={$posts_admin['post_id']}' class='btn btn-outline-info bg-info'>{$posts_admin['post_comment_count']}</a></td>";
                echo "<td>{$posts_admin['post_date']}</td>";
                echo "<td>{$posts_admin['post_content']}</td>";
                echo "<td>{$posts_admin['post_views_count']}</td>";
                echo "<td><a href='../post.php?get_posts_id={$posts_admin['post_id']}' class='btn btn-outline-info bg-info'>View Post</a></td>";
                echo "<td><a href='./admin_posts.php?change_to_published={$posts_admin['post_id']}' class='btn btn-outline-success bg-success' onclick=\"return confirm('Are you sure you want to publish the \'{$posts_admin['post_head']}\' post ?')\">Published</a></td>";
                echo "<td><a href='./admin_posts.php?change_to_draft={$posts_admin['post_id']}' class='btn btn-outline-primary bg-primary' onclick=\"return confirm('Are you sure you want to draft the \'{$posts_admin['post_head']}\' post ?')\">Draft</a></td>";
                echo "<td><a href='./admin_posts.php?delete={$posts_admin['post_id']}' class='btn btn-outline-danger bg-danger' onclick=\"return confirm('Are you sure you want to delete the \'{$posts_admin['post_head']}\' post ?')\">Delete</a></td>";
                echo "<td><a href='./admin_posts.php?source=edit_posts&id_posts={$posts_admin['post_id']}' class='btn btn-outline-warning bg-warning'>Edit</a></td>";
                echo "<tr>";
            }
        }
    } catch (PDOException $e) {
        echo "Can not return the posts" . $e->getMessage();
    }
}
?>