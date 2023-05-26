<?php
// Check the check_posts function to return the posts table
if (isset($cms_pdo) && !empty($cms_pdo)) {
    try {
        $admin_users = check_users($cms_pdo);
        if (!empty($admin_users) ) {
            foreach ($admin_users as $all_users) {
                echo "<tr>";
                echo "<td>{$all_users['user_id']}</td>";
                echo "<td>{$all_users['firstname']}</td>";
                echo "<td>{$all_users['lastname']}</td>";
                echo "<td>{$all_users['email']}</td>";
                echo "<td>{$all_users['joined']}</td>";
                echo "<td>{$all_users['last_login']}</td>";
                echo "<td>{$all_users['active']}</td>";
                echo "<td>{$all_users['username']}</td>";
                echo "<td>{$all_users['user_image']}</td>";
                echo "<td>{$all_users['user_role']}</td>";
                echo "<td><a href='./admin_users.php?change_to_admin={$all_users['user_id']}' class='btn btn-outline-success bg-success' onclick=\"return confirm('Are you sure you want to change the \'{$all_users['username']}\' user to admin ?')\">Admin</a></td>";
                echo "<td><a href='./admin_users.php?change_to_sub={$all_users['user_id']}' class='btn btn-outline-info bg-info' onclick=\"return confirm('Are you sure you want to change the \'{$all_users['username']}\' user to subscriber ?')\">Subscriber</a></td>";
                echo "<td><a href='./admin_users.php?delete_users={$all_users['user_id']}' class='btn btn-outline-danger bg-danger' onclick=\"return confirm('Are you sure you want to delete the \'{$all_users['username']}\' user ?')\">Delete</a></td>";
                echo "<td><a href='./admin_users.php?source=edit_users&id_users={$all_users['user_id']}' class='btn btn-outline-warning bg-warning'>Edit</a></td>";
                echo "<tr>";
                }
            }      
        } catch (PDOException $e) {
            echo "Can not return the posts" . $e->getMessage();
        }
}
?>