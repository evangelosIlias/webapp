<?php

// The User count activity working with session, each time the user is logged in a new session starts and receives information from there.
function UserCountActivity($cms_pdo) {
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $cms_pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $user_id = $user['user_id'];
        $username = $user['username'];
        $joined = $user['joined'];

        // Rest of the code based on session
        $userId = $_SESSION['user_id'] ?? null;
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        if (!empty($user)) {
            $stmt = $cms_pdo->prepare("SELECT * FROM users_online WHERE user_id = ?");
            $stmt->execute([$userId]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                // The user exists in the online users table, update last activity
                $stmt = $cms_pdo->prepare("UPDATE users_online SET last_activity = CURRENT_TIMESTAMP, ip_address = ?, user_agent = ? WHERE user_id = ?");
                $stmt->execute([$ipAddress, $userAgent, $userId]);
            } else {
                // The user exists in the session but not in the online users table, insert a new user
                $stmt = $cms_pdo->prepare("INSERT INTO users_online (user_id, username, joined, last_activity, ip_address, user_agent) SELECT ?, ?, ?, CURRENT_TIMESTAMP, ?, ? WHERE NOT EXISTS (SELECT * FROM users_online WHERE user_id = ?)");
                $stmt->execute([$user_id, $username, $joined, $ipAddress, $userAgent, $user['user_id']]);
            }
        } 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Set the time zone
    date_default_timezone_set('Europe/Athens');
    $cms_pdo->prepare("SET time_zone = '+03:00'");

    $inactiveTime = date('Y-m-d H:i:s', time() - (5 * 60)); // 5 minutes

    $stmt = $cms_pdo->prepare("DELETE FROM users_online WHERE last_activity < :inactive_time");
    $stmt->bindValue(':inactive_time', $inactiveTime);
    $stmt->execute();

    // Fetch all remaining users after deletion
    $stmt = $cms_pdo->query("SELECT * FROM users_online");
    $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $cms_pdo->query("SELECT COUNT(*) FROM users_online");
    $count_users_online = $stmt->fetchColumn();
    return $count_users_online;

    }
}
?>

<script>
// Ajax loading page
function refreshPage() {
    location.reload();
}
setTimeout(refreshPage, 900000); // 15 minutes = 900 seconds * 1000 milliseconds
</script>


