<?php 
// $comment_post_id = "";
// $comment_email = "";
// $comment_content = "";
// $comment_status = "";
// $comment_date = "";

// // Initialiazing the error with an empty array 
// $error = array();

// $user_id = $_SESSION['user_id'];

// // If is set the GET method return the id_posts parameter
// if (isset($_GET['id_comments'])) {
//     $id_comments = $_GET['id_comments'];
    
//     // Checking the posts based on GET post_id and return all the columns with rows
//     function comments_result_by_id($cms_pdo, $id_comments, $comment_post_id, $user_id) {
//         try {
//             $stmt = $cms_pdo->prepare("SELECT * FROM comments WHERE comment_id = :comment_id AND comment_post_id = :comment_post_id AND user_id = :user_id");
//             $stmt->bindParam(":comment_id", $id_comments, PDO::PARAM_INT);
//             $stmt->bindParam(":comment_post_id", $comment_post_id, PDO::PARAM_INT);
//             $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
//             $stmt->execute();
//             $post_result = $stmt->fetch(PDO::FETCH_ASSOC);
//             return $post_result;
//         } catch (PDOException $e) {
//             echo "Error with the returned post: " . $e->getMessage();
//         }
//     }
    
//     $comments_result_by_id = comments_result_by_id($cms_pdo, $id_comments, $comment_post_id, $user_id);

// // Checking if the name=sumbit is being set from HTML form 
// if (isset($_POST['submit'])) {
//     $comment_post_id = $_POST['comment_post_id'];
//     $comment_email = $_POST['comment_email'];
//     $comment_content = $_POST['comment_content'];
//     $comment_status = $_POST['comment_status'];
//     $comment_date = $_POST['comment_date'];

//     try {
//         // Update the post in the database
//         $sql = "UPDATE comments SET comment_content = :comment_content WHERE comment_post_id = :comment_post_id";
//         $stmt = $cms_pdo->prepare($sql);
//         $stmt->execute(array(
//             ':comment_content' => ucfirst(strtolower($comment_content)),
//             ':comment_post_id' => $id_comments
//         ));
        
//         // Set a success message in a session variable
//         $_SESSION['success_message'] = "Your comments has been successfully updated. Please check Comments page";

//         // Redirect to the same page to display the message by refreshing the page
//         header("Location: {$_SERVER['REQUEST_URI']}");
//         exit;
        
//     } catch (PDOException $e) {
//         // Display an error message
//         echo "Error updating the posts" .  $e->getMessage();
//     }
// }

// // If there is a success message in the session, display it and remove it from the session
// if (isset($_SESSION['success_message'])) {
//     echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
//     unset($_SESSION['success_message']);
// }
// ?>
//  <!-- Edit form for posts -->
<!-- //  <form method="post" action="" enctype="multipart/form-data">
//     <div class="form-group">    
//         <input type="hidden" name="comment_id" value="<?php echo $comments_result_by_id['comment_id']; ?>">
//     </div>
//     <div class="form-group">    
//         <label for="post_head">Comment Post id</label>
//         <input value= "<?php echo $comments_result_by_id['comment_post_id']; ?>" type="text" class="form-control" name="comment_post_id">
//     </div>
//     <div class="form-group">
//         <label for="post_title">Comment Author</label>
//         <input value= "<?php echo $comments_result_by_id['comment_author']; ?>" type="text" class="form-control" name="comment_author">
//     </div>
//     <div class="form-group">
//         <label for="post_author">Comment email</label>
//         <input value= "<?php echo $comments_result_by_id['comment_email']; ?>" type="text" class="form-control" name="comment_email">
//     </div>
//     <div class="form-group">
//         <label for="post_status">Coment date</label>
//         <input value= "<?php echo $comments_result_by_id['comment_date']; ?>" type="text" class="form-control" name="comment_date">
//     </div>
//     <div class="form-group">
//         <label for="post_tags">Coment Status</label>
//         <input value= "<?php echo $comments_result_by_id['comment_status'] ?>" type="text" class="form-control" name="comment_status">
//     </div>
//     <div class="form-group">
//         <label for="post_content">Comment Content</label>
//         <textarea class="form-control" name="comment_content" id="" cols="30" rows="10"><?php echo $comments_result_by_id['comment_content']; ?></textarea>
//     </div>
//     <div class="form-group">
//         <input type="submit" class="btn btn-warning" name="submit" value="Update Comment">
//     </div>
// </form>
// <?php
// } -->
?>