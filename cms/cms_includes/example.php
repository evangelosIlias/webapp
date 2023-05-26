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
                // echo "New user inserted into database.";
            }
        } 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Checking the inactivity after 1 min and updating the user in the database
    // $inactiveUser = new DateInterval('PT5S');
    // $inactiveTimeUser = (new DateTime())->sub($inactiveUser)->format('Y-m-d H:i:s');

    // $stmt = $cms_pdo->prepare("UPDATE users_online SET last_activity = CURRENT_TIMESTAMP WHERE last_activity < :inactive_time");
    // $stmt->bindValue(':inactive_time', $inactiveTimeUser);
    // $stmt->execute();

    // Checking for inactivity after 2 mins and deleting the user from the database 
    $inactiveInterval = new DateInterval('PT10S'); // Change to a longer interval if needed
    $inactiveTime = (new DateTime())->sub($inactiveInterval)->format('Y-m-d H:i:s');

    // Logging start time
    $startTime = time();

    $stmt = $cms_pdo->prepare("DELETE FROM users_online WHERE last_activity < :inactive_time");
    $stmt->bindValue(':inactive_time', $inactiveTime);
    $stmt->execute();

    $deleteCount = $stmt->rowCount();
    echo "Deleted $deleteCount inactive user(s).<br>";

    // Logging end time
    $endTime = time();

    // Calculate the time taken for deletion
    $timeTaken = $endTime - $startTime;
    echo "Time taken for deletion: $timeTaken seconds<br>";

    // Debug: Fetch all remaining users after deletion
    $stmt = $cms_pdo->query("SELECT * FROM users_online");
    $remainingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $stmt = $cms_pdo->prepare("SELECT last_activity FROM users_online WHERE user_id = ?");
    // $stmt->execute([$userId]);
    // $lastActivity = $stmt->fetchColumn();

    //$displayTimezone = 'Europe/Athens';

    // $lastActivityDateTime = new DateTime($lastActivity);
    // $lastActivityDateTime->setTimezone(new DateTimeZone($displayTimezone));
    // $formattedLastActivity = $lastActivityDateTime->format('H:i:s');

    // $currentDate = date('Y-m-d');

    $stmt = $cms_pdo->query("SELECT COUNT(*) FROM users_online");
    $count_users_online = $stmt->fetchColumn();
    return $count_users_online;
   
    }
}
?>







<?php
// Checking for inactivity after 5 seconds and deleting the user from the database 
$inactiveTime = date('Y-m-d H:i:s', time() - 5);

$stmt = $cms_pdo->prepare("DELETE FROM users_online WHERE last_activity < :inactive_time");
$stmt->bindValue(':inactive_time', $inactiveTime);
$stmt->execute();

$deleteCount = $stmt->rowCount();
echo "Deleted $deleteCount inactive user(s).<br>";

// Fetch all remaining users after deletion
$stmt = $cms_pdo->query("SELECT * FROM users_online");
$remainingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the remaining users
print_r($remainingUsers);

$stmt = $cms_pdo->query("SELECT COUNT(*) FROM users_online");
$count_users_online = $stmt->fetchColumn();
return $count_users_online;


$UserCountActivity = UserCountActivity($cms_pdo);
var_dump($UserCountActivity);