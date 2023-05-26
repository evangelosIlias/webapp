<?php
// Check if a search query is provided
if (isset($_POST['admin_search_posts'])) {
    $source_search = $_POST['admin_search_posts'];
    $check_admin_search = admin_search_wildcard($cms_pdo, $source_search);
    if (!empty($check_admin_search)) {
        $_SESSION['post_id'] = $check_admin_search[0]['post_id'];
        foreach ($check_admin_search as $admin_search) {
            
            echo "<tr>";
            echo "<td>{$admin_search['post_id']}</td>";
            echo "<td>{$admin_search['post_head']}</td>";
            echo "<td>{$admin_search['post_author']}</td>";
            echo "<td><a href='../post.php?get_posts_id={$admin_search['post_id']}'>{$admin_search['post_title']}</a></td>";
            $categories = get_post_with_category_title($cms_pdo);
            foreach ($categories as $category) {
                if ($category['cat_id'] == $admin_search['post_category_id']) {
                    $cat_title = $category['cat_title'];
                    break;
                }
            }
            echo "<td>{$cat_title}</td>";
            echo "<td>{$admin_search['post_status']}</td>";
            echo "<td><img src='./admin_upload_images/{$admin_search['post_image']}' width='50px' height='30px' alt='image'></td>";
            echo "<td>{$admin_search['post_tags']}</td>";
            echo "<td><a href='./admin_com_per_post.php?unique_com_post={$admin_search['post_id']}' class='btn btn-outline-info bg-info'>{$admin_search['post_comment_count']}</a></td>";
            //echo "<td><a href='./admin_comments.php?get_posts_id={$admin_search['post_comment_count']}' class='btn btn-outline-info bg-info'>{$admin_search['post_comment_count']}</a></td>";
            echo "<td>{$admin_search['post_date']}</td>";
            echo "<td>{$admin_search['post_content']}</td>";
            echo "<td>{$admin_search['post_views_count']}</td>";
            echo "<td><a href='../post.php?get_posts_id={$admin_search['post_id']}' class='btn btn-outline-info bg-info'>View Post</a></td>";
            echo "<td><a href='./admin_search_posts.php?search_change_published={$admin_search['post_id']}' class='btn btn-outline-success bg-success' onclick=\"return confirm('Are you sure you want to publish the \'{$admin_search['post_head']}\' post ?')\">Published</a></td>";
            echo "<td><a href='./admin_search_posts.php?search_change_draft={$admin_search['post_id']}' class='btn btn-outline-primary bg-primary' onclick=\"return confirm('Are you sure you want to draft the \'{$admin_search['post_head']}\' post ?')\">Draft</a></td>";
            echo "<td><a href='./admin_search_posts.php?search_delete={$admin_search['post_id']}' class='btn btn-outline-danger bg-danger' onclick=\"return confirm('Are you sure you want to delete the \'{$admin_search['post_head']}\' post ?')\">Delete</a></td>";
            echo "<td><a href='./admin_posts.php?source=edit_posts&id_posts={$admin_search['post_id']}' class='btn btn-outline-warning bg-warning'>Edit</a></td>";
            echo "<tr>";
            }
            } else {
                echo "<h2>No results were found for '$source_search'</h2>";
                echo "<h3>Hit the 'View All Posts' to return to the main posts or try a different keyword</h3>";
                }
            }
        ?>