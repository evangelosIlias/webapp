<?php
// Session will store data across multiple HTTP requests and start or resumes an existing session
session_start();

// Buffering the output of a PHP script in memory before sent to the browser
ob_start();

// Establish connection to the 'cms' database
$cms_dsn = "pgsql:host=localhost; dbname=cms; port=5432";
$cms_opt = [
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      => false
    ];
    try { 
        $cms_pdo = new PDO ($cms_dsn, 'postgres', '%%eE^cG7qbA!HW', $cms_opt);
    } catch (PDOException $e) {
        echo 'Connection to cms database failed: '. $e->getMessage();
    }

?>