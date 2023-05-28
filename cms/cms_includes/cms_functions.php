<?php
    // Setting up the messages based on colour
    function set_msg($msg, $class = '') {
        if(empty($msg)) {
            unset($_SESSION['message']);
        } elseif ($class == 'green_color') {
            $_SESSION['message'] = "<div class='green_color {$class}'><span>{$msg}</span></div>";
        } else {
            $class == 'red_color'; 
            $_SESSION['message'] = "<div class='red_color {$class}'><span>{$msg}</span></div>";
        }
    }

    // Show message function to the HTML client side page based on colour you picked-up
    function show_msg($class = '') {
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
    }

    // Send email to user 
    function send_email($to, $subject, $body, $from, $reply) {
        $headers =  "From: {$from} ". "\r\n" .
                    "Reply-To: {$reply}" . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
        if ($_SERVER['SERVER_NAME' != "localhost"]) {
            mail($to, $subject, $body, $headers);
        } else {
            echo "<hr><p>To:{$to}</p><p>Subject:{$subject}</p><p>{$body}</p><p>".$headers."</p><hr>"; 
        }            
    }

    // This function categories will check the database and return all the cat_titles values
    function get_categories($cms_pdo) {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            echo "Error categories cant be found: " . $e->getMessage();
            return false;
        }
    }

    // This function categories will check the database and return all the posts
    function check_posts($cms_pdo) {
        try {
            $sql = "SELECT * FROM posts";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "Error post cant be found: " . $e->getMessage();
            return false;
        }
    }
    
     // Checking the posts based on GET post_id and return all the columns with rows
     function check_post_id($cms_pdo, $get_posts_id) {
        try {
            if (!is_numeric($get_posts_id)) {
                throw new InvalidArgumentException("post id is not a number");
            }
            $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
            $stmt->bindParam(":post_id", $get_posts_id, PDO::PARAM_INT);
            $stmt->execute();
            $post_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $post_result;
        } catch (PDOException $e) {
            echo "Error with the returned post in post.php: " . $e->getMessage();
        }
    }

    // This function categories will check the database and return all the posts based on post_status
    function check_posts_status($cms_pdo, $offset, $limit) {
        try {
            $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_status = 'published' LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "Error retrieving posts: " . $e->getMessage();
            return false;
        }
    }
    

    // That function will check SQL database
    function check_post_duplicate($cms_pdo, $tbl, $fld, $val) {
        try{
            $sql = "SELECT {$fld} FROM {$tbl} WHERE {$fld} = :value";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['value' => $val]);
            return $stmnt->rowCount();
        } catch (PDOException $e){
            echo "Error, the count field val is not found ". $e->getMessage();
            return false;
        }
    }

    // Count the post visits
    function post_views_count($cms_pdo, $get_posts_id) {
        try {
            // Check if the post exists
            $stmt = $cms_pdo->prepare("SELECT post_views_count FROM posts WHERE post_id = :post_id");
            $stmt->bindParam(':post_id', $get_posts_id);
            $stmt->execute();
            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$post) {
                // If the post does not exist, insert a new row with post_id and post_views_count set to 0
                $stmt = $cms_pdo->prepare("INSERT INTO posts (post_id, post_views_count) VALUES (:post_id, 0)");
                $stmt->bindParam(':post_id', $get_posts_id);
                $stmt->execute();
            }

            // Increment the post_views_count by 1
            $sql = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = :post_id";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->bindParam(':post_id', $get_posts_id);
            $stmt->execute();

            $row_count = $stmt->rowCount();
            return $row_count;
        } catch (PDOException $e) {
            return "Error: Unable to count the post views. " . $e->getMessage();
        }
    }

    // Checking the posts based on GET post_id and return all the columns with rows
    function check_categories_id($cms_pdo, $get_blog_categories) {
        try {
            $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_category_id = :post_category_id");
            $stmt->bindParam(":post_category_id", $get_blog_categories, PDO::PARAM_INT);
            $stmt->execute();
            $post_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $post_result;
        } catch (PDOException $e) {
            echo "Error with the returned post: " . $e->getMessage();
        }
    }
    
    // This function will check the databse and return all the wildcards tags from the search engine
    function search_wildcard($cms_pdo, $search) {
        try {
            $sql = "SELECT * FROM posts WHERE post_status = 'published' AND post_tags LIKE :search";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->bindValue(':search',"%$search%", PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e){
            echo "Error search cant be found: " . $e->getMessage();
            return false;
        }
    }

    // Validation code
    function get_validationcode($cms_pdo, $email) {
        try{
            $stmnt=$cms_pdo->prepare("SELECT validationcode FROM users WHERE email=:email");
            $stmnt->execute([':email' => $email]);
            $row = $stmnt->fetch();
            return $row['validationcode'];
        } catch (PDOException $e){
            echo "Error validation cant be found: " . $e->getMessage();
            return false;
        }
    }

    // That function will check the first row in database and return if the arguemnt exists or not
    function return_field_data($cms_pdo, $tbl, $fld, $val) {
        try{
            $sql = "SELECT * FROM {$tbl} WHERE {$fld} = :value";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['value' => $val]);
            return $stmnt->fetch();
        } catch (PDOException $e){
            echo "Error return field data cant be found: " . $e->getMessage();
            return false;
        }
    }

    // This function categories will check the database and return all the cat_titles values
    function cms_categories($cms_pdo) {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            echo "Error categories can not be found: " . $e->getMessage();
        }
    }

    // Login function checking for cookie on email session
    function cms_check_logged_status() {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            if (isset($_COOKIE['email'])) {
                $_SESSION['email'] = $_COOKIE["email"];
                return true;
            } else {
                return false;
            }
        }
    }

?>    