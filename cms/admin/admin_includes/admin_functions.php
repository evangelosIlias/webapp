<?php
    // Check users
    function users_online($cms_pdo) {
        try {
            $sql = "SELECT * FROM users_online";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error users online cant be found: " . $e->getMessage();
        } 
    }

    // Check users
    function check_users($cms_pdo) {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error users cant be found: " . $e->getMessage();
        } 
    }

    // Check users
    function check_sub_users($cms_pdo) {
        try {
            $sql = "SELECT * FROM users WHERE user_role = 'subscriber'";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error users and users role cant be found: " . $e->getMessage();
        } 
    }

    // Check users
    function check_non_sub_users($cms_pdo) {
        try {
            $sql = "SELECT * FROM users WHERE user_role = ''";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error users and user role cant be found: " . $e->getMessage();
        } 
    }

     // Checking the posts based on GET post_id and return all the columns with rows
     function user_result_by_id($cms_pdo, $id_users) {
        try {
            $stmt = $cms_pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $id_users, PDO::PARAM_INT);
            $stmt->execute();
            $user_result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user_result;
        } catch (PDOException $e) {
            echo "Error with the user_result_by_id function: " . $e->getMessage();
        }
    }
    
    // Check comments
    function check_comments($cms_pdo) {
        try {
            $sql = "SELECT * FROM comments";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        } catch (PDOException $e) {
            echo "Error comments cant be found: " . $e->getMessage();
        }
    }

    // Check comments
    function check_unapproved_comments_($cms_pdo) {
        try {
            $sql = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        } catch (PDOException $e) {
            echo "Error unapproved comments cant be found: " . $e->getMessage();
        }
    }

    // Check comments
    function check_approved_comments_($cms_pdo) {
        try {
            $sql = "SELECT * FROM comments WHERE comment_status = 'approved'";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        } catch (PDOException $e) {
            echo "Error approved comments cant be found: " . $e->getMessage();
        }
    }
    
    // Check both tables posts and categories and return cat_titles from categories
    function get_post_with_category_title($cms_pdo) {
        try {
            $sql = "SELECT c.cat_id, c.cat_title
                    FROM posts p
                    INNER JOIN categories c
                    ON p.post_category_id = c.cat_id";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $cat_titles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $cat_titles;
        } catch (PDOException $e) {
            echo "Error posts and categories tables can not be found: " . $e->getMessage();
        }
    }

    // This function categories will check the database and return all the cat_titles values
    function admin_categories($cms_pdo) {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            echo "Error categories cannot be found: " . $e->getMessage();
            return false;
        }
    }
    // GEt categories by ID
    function get_category_by_id($cms_pdo, $cat_id) {
        try {
            $sql = "SELECT * FROM categories WHERE cat_id = :cat_id";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->bindParam(':cat_id', $cat_id);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category;
        } catch (PDOException $e) {
            echo "Error retrieving category: " . $e->getMessage();
        }
    }

     // This function categories will check the database and return all the cat_titles values from post table
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

    // This function categories will check the database and return all the cat_titles values from post table
    function check_draft_posts($cms_pdo) {
        try {
            $sql = "SELECT * FROM posts WHERE post_status = 'draft'";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posts;
        } catch (PDOException $e) {
            echo "Error post cant be found: " . $e->getMessage();
            return false;
        }
    }

    // This function categories will check the database and return all the cat_titles values from post table
    function check_published_posts($cms_pdo) {
        try {
            $sql = "SELECT * FROM posts WHERE post_status = 'published'";
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
    function post_result_by_id($cms_pdo, $id_posts) {
        try {
            $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
            $stmt->bindParam(":post_id", $id_posts, PDO::PARAM_INT);
            $stmt->execute();
            $post_result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $post_result;
        } catch (PDOException $e) {
            echo "Error with the post_result_by_id function: " . $e->getMessage();
        }
    }
    
     // That function will check SQL database
     function post_duplicate($cms_pdo, $tbl, $fld, $val) {
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

     // Checking the posts based on GET post_id and return all the columns with rows
     function admin_search_by_id($cms_pdo, $search_edit) {
        try {
            $stmt = $cms_pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
            $stmt->bindParam(":post_id", $search_edit, PDO::PARAM_INT);
            $stmt->execute();
            $post_result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $post_result;
        } catch (PDOException $e) {
            echo "Error with the post_result_by_id function: " . $e->getMessage();
        }
    }
    
    // This function will check the databse and return all the wildcards tags from the search engine
    function admin_search_wildcard($cms_pdo, $source_search) {
        try {
            $sql = "SELECT * FROM posts WHERE post_tags LIKE :searchQuery";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->bindValue(':searchQuery',"%$source_search%", PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e){
            echo "Error admin search cant be found: " . $e->getMessage();
        }
    }

    // That function will check the username in database if exists or not
    function username_duplicate($cms_pdo, $username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmnt = $cms_pdo->prepare($sql);
            $stmnt->execute(['username' => $username]);
            return $stmnt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // That function will check SQL database
    function check_duplicates_values($cms_pdo, $tbl, $fld, $val) {
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

    // That function will retrun encode token for encryption "Is not recommened"
    function encryption_gene() {
        return md5(microtime().mt_rand());
    }

    // Count the posts
    function count_row_posts($cms_pdo) {
        try {
            $sql = "SELECT * FROM posts";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $num_posts = $stmt->rowCount(); 
            return $num_posts;
        } catch (PDOException $e) { 
            echo  "Error:" .$e->getMessage();
        }
    } 

    // Count the comments
    function count_row_comments($cms_pdo) {
        try {
            $sql = "SELECT * FROM comments";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $num_comments = $stmt->rowCount(); 
            return $num_comments;
        } catch (PDOException $e) {
            echo  "Error:" .$e->getMessage();
        }
    }

    // Count the users
    function count_row_users($cms_pdo) {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $num_users = $stmt->rowCount(); 
            return $num_users;
        } catch (PDOException $e) {
            echo  "Error:" .$e->getMessage();
        }
    }

    // Count the users
    function count_row_cat($cms_pdo) {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->execute();
            $num_cat = $stmt->rowCount(); 
            return $num_cat;
        } catch (PDOException $e) {
            echo  "Error:" .$e->getMessage();
        }
    }
?>    