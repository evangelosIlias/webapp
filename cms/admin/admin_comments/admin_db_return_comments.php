<?php
// Check the check_comment function to return the comment table
if (isset($cms_pdo) && !empty($cms_pdo)) {
    try {
        $admin_comments = check_comments($cms_pdo);
        if (!empty($admin_comments)) {
            foreach ($admin_comments as $comment) {
                echo "<tr>";
                echo "<td>{$comment['comment_id']}</td>";
                echo "<td>{$comment['comment_post_id']}</td>";
                echo "<td>{$comment['comment_author']}</td>";
                echo "<td>{$comment['comment_email']}</td>";
                echo "<td>{$comment['comment_status']}</td>";
                echo "<td>{$comment['comment_date']}</td>";
                // Checking first the posts table and return the post_id and post_title, if the post_id is same with comment_post_id then return the post_tile
                // of each categorie
                $post_id = null;
                $post_image = null;
                $post_title = null;
                $admin_posts = check_posts($cms_pdo);
                if (!empty($admin_posts)) {
                    foreach ($admin_posts as $posts_admin) {
                        $posts_admin['post_id'];
                        $posts_admin['post_title'];
                        $posts_admin['post_image'];
                        if ($comment['comment_post_id'] == $posts_admin['post_id']) {
                            $post_title = $posts_admin['post_title'];
                            $post_id = $posts_admin['post_id'];
                            $post_image = $posts_admin['post_image'];
                            break;
                        }
                    }
                }
                echo "<td><a href='../post.php?get_posts_id={$post_id}'>{$comment['comment_content']}</a></td>";
                echo "<td><a href='./admin_posts.php?get_posts_id={$post_id}'>{$post_title}</a></td>";
                echo "<td><img src='./admin_upload_images/{$post_image}' width='50px' height='30px' alt='image'></td>";
                echo "<td><a href='./admin_comments.php?approved_comment={$comment['comment_id']}' class='btn btn-outline-success bg-success' onclick=\"return confirm('Are you sure you want to approve the \'{$comment['comment_status']}\' comment ?')\">Approved</a></td>";
                echo "<td><a href='./admin_comments.php?unapproved_comment={$comment['comment_id']}' class='btn btn-outline-info bg-info' onclick=\"return confirm('Are you sure you want to unapprove the \'{$comment['comment_status']}\' comment ?')\">Unapproved</a></td>";
                echo "<td><a href='./admin_comments.php?delete_comment={$comment['comment_id']}&get_posts_id={$post_id}' class='btn btn-outline-dabger bg-danger' onclick=\"return confirm('Are you sure you want to delete the \'{$comment['comment_content']}\' comment ?')\">Delete</a></td>";
                echo "<tr>";
            }
        }
    } catch (PDOException $e) {
        echo "Can not return the comments: " . $e->getMessage();
    }
}
?>
