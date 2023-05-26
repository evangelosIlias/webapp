<?php
// Define the display timezone
$displayTimezone = 'Europe/Athens';

// Check the users online table
if (isset($cms_pdo) && !empty($cms_pdo)) {
    try {
        // Retrieve online users
        $stmt = $cms_pdo->query("SELECT * FROM users_online");
        $users_online = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($users_online)) {
            foreach ($users_online as $online_user) {
                echo "<tr>";
                echo "<td>{$online_user['user_id']}</td>";
                echo "<td>{$online_user['username']}</td>";
                echo "<td>{$online_user['joined']}</td>";

                // Format the last_activity value
                $lastActivityDateTime = new DateTime($online_user['last_activity']);
                $lastActivityDateTime->setTimezone(new DateTimeZone($displayTimezone));
                $formattedLastActivity = $lastActivityDateTime->format('Y-m-d H:i:s');

                echo "<td>{$formattedLastActivity}</td>";
                echo "<td>{$online_user['ip_address']}</td>";
                echo "<td>{$online_user['user_agent']}</td>";
                echo "</tr>";
            }
        } else {
            echo "No online users found";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
