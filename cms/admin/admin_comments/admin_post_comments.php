<?php 
// Checking first if the cms_pdo isset to avoid errors
$get_posts_id = null; 
if(isset($cms_pdo) && !empty($cms_pdo)) {
    // Checking if the GET superglobal is set to get_post_id
    if(isset($_GET['get_posts_id'])) {
        $get_posts_id = $_GET['get_posts_id'];
    }
    // Creating a function to check the get_posts_id and comment_status
    function get_comments_and_status($cms_pdo, $get_posts_id) {
        try {
            $sql = "SELECT * FROM comments WHERE comment_post_id = :post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
            $stmt = $cms_pdo->prepare($sql);
            $stmt->bindParam(':post_id', $get_posts_id, PDO::PARAM_INT);
            $stmt->execute();
            $posted_comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $posted_comments;
        } catch (PDOException $e) {
            echo "Error cant find the comments " . $e->getMessage();
        }
    }
// Looping through and return the vales to HTML    
$get_comments_and_status = get_comments_and_status($cms_pdo, $get_posts_id);
foreach($get_comments_and_status as $returned_post_commets) {

?>

<!-- Comment -->
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><?php echo $returned_post_commets['comment_author']?>
            <small><?php echo $returned_post_commets['comment_date']?></small>
        </h4>
        <?php echo $returned_post_commets['comment_content']?>
    </div>
</div>
<?php 
    } 
}?>