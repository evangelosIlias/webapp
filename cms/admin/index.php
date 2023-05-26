<?php include "../../includes/database.php"; ?>
<?php include "admin_includes/admin_header.php" ?>
<?php include "admin_includes/admin_functions.php" ?>

<div id="wrapper">

<!-- Navigation -->
<?php include "admin_includes/admin_nav.php"; ?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Admin
                    <small>
                        <?php  
                        if(isset($_SESSION['username'])) {
                            echo $_SESSION['username'];
                        }?>
                        </small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

<!-- Widgets Dashboard starts here -->
<!-- /.row -->            
 <div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                <div class='huge'><?php echo $count_row_posts = count_row_posts($cms_pdo); ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="admin_posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $count_row_comments = count_row_comments($cms_pdo);?></div>
                    <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="admin_comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $count_row_users = count_row_users($cms_pdo); ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="admin_users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class='huge'><?php echo $count_row_cat = count_row_cat($cms_pdo);?></div>
                        <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="admin_categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- Widgets Dashboard ends here -->
<?php
// Retrun the count of the functions to display the total numbers from database
$check_draft_posts = count(check_draft_posts($cms_pdo));
$check_comments_status = count(check_unapproved_comments_($cms_pdo));
$check_published_posts = count(check_published_posts($cms_pdo));
$check_approved_comments = count(check_approved_comments_($cms_pdo));
$check_sub_users = count(check_sub_users($cms_pdo));
$check_non_sub_users = count(check_non_sub_users($cms_pdo));
?>
<!-- Creating array with keys and values of chart bar dashboard -->
<?php  
$elements = [
    ['Posts', $count_row_posts],
    ['Draft Posts', $check_draft_posts],
    ['Published Posts', $check_published_posts],
    ['Comments', $count_row_comments],
    ['Unapproved', $check_comments_status],
    ['Approved', $check_approved_comments],
    ['Users', $count_row_users],
    ['Subscribers', $check_sub_users],
    ['Non subscribers', $check_non_sub_users],
    ['Categories', $count_row_cat],
];
$data = "['Date', 'Count'],";
foreach ($elements as $element) {
    $data .= "['{$element[0]}', {$element[1]}],";
}
?>
<!-- Chart bar Dashboard starts here -->
<script>
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        <?php echo $data ?>
    ]);

    var options = {
        chart: {
                title: 'Current Stats',
                subtitle: '<?php echo date("F j, Y"); ?>',
                },
        legend: { position: 'right' },
        colors: ['#e58cdb'],
        hAxis: {
            title: 'Number of',
            titleTextStyle: {
                fontSize: 16,
                bold: true,
            },
            textStyle: {
                fontSize: 14,
            },
        },
        vAxis: {
            titleTextStyle: {
                fontSize: 16,
                bold: true,
            },
            textStyle: {
                fontSize: 14,
            },
        },
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>
<!-- Chart bar Dashboard ends here -->
<div class="row">
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>
<!-- Chart bar Dashboard ends here -->
                    
</div>
<!-- /.container-fluid -->

</div>

<!-- /#page-wrapper -->
<?php include "admin_includes/admin_footer.php"; ?>