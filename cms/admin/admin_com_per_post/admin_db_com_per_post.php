<?php
// Check the check_comment 
if (isset($cms_pdo) && !empty($cms_pdo)) {
    if (isset($_GET['unique_com_post'])) {
        $unique_com_post = $_GET['unique_com_post'];

        try {
            // Check comments id
            function get_com_per_post($cms_pdo, $unique_com_post) {
                try {
                    $sql = "SELECT * FROM comments WHERE comment_post_id = :unique_com_post";
                    $stmt = $cms_pdo->prepare($sql);
                    $stmt->bindParam(':unique_com_post', $unique_com_post);
                    $stmt->execute();
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $comments;
                } catch (PDOException $e) {
                    echo "Error: Comments per post cant be found - " . $e->getMessage();
                }
            }

            // Call the function
            $get_com_per_post = get_com_per_post($cms_pdo, $unique_com_post);

            if (empty($get_com_per_post)) {
                // Set a success message in a session variable
                $_SESSION['no_comm_on_post'] = "No comments on that post";
            } else {
                foreach ($get_com_per_post as $comment) {
                    // Display comments
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
                    echo "<td><a href='./admin_com_per_post.php?appr_com_per_post={$comment['comment_id']}&unique_com_post={$post_id}' class='btn btn-outline-success bg-success' onclick=\"return confirm('Are you sure you want to approve the \'{$comment['comment_status']}\' comment ?')\">Approved</a></td>";
                    echo "<td><a href='./admin_com_per_post.php?un_com_per_post={$comment['comment_id']}&unique_com_post={$post_id}' class='btn btn-outline-info bg-info' onclick=\"return confirm('Are you sure you want to unapprove the \'{$comment['comment_status']}\' comment ?')\">Unapproved</a></td>";
                    echo "<td><a href='./admin_com_per_post.php?del_com_per_post={$comment['comment_id']}&unique_com_post={$post_id}' class='btn btn-outline-dabger bg-danger' onclick=\"return confirm('Are you sure you want to delete the \'{$comment['comment_content']}\' comment ?')\">Delete</a></td>";
                    echo "<tr>";
                }
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
// If there is a success message in the session, display it and remove it from the session
if (isset($_SESSION['no_comm_on_post'])) {
    echo "<div class='alert alert-success'>{$_SESSION['no_comm_on_post']}</div>";
    unset($_SESSION['no_comm_on_post']);
}
?>
