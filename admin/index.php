<?php include "includes/admin_header.php"; ?>
<?php include "../includes/dashboard_functions.php"; ?>

<div id="wrapper">
<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



$session = session_id();
$time = time();
$time_out_in_seconds = 60;
$time_out = $time - $time_out_in_seconds;

// Check if the session already exists in the database
$query = "SELECT * FROM users_online WHERE session = '$session'";
$send_query = mysqli_query($connection, $query);
$count = mysqli_num_rows($send_query);

// If no session exists, insert a new session record
if ($count == NULL) {
    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
} else {
    // If session exists, update the existing session record
    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
}

// Query to count the number of active users (sessions updated within the last 60 seconds)
$users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
$count_user = mysqli_num_rows($users_online_query);

?>






    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">  
                    <h1 class="page-header">
                        Welcome to admin 
                        <small><?php echo $_SESSION['username']; ?></small>
                        <small><?php echo $count_user; ?> users are online</small>
                    </h1>
                    <h1>
                      <!--  <small> <?php// echo $count_user; ?> users online</small> -->

                </div>
            </div>

            <?php 
            $post_count = echo_count_post();
            $comment_count = echo_count_comments();
            $user_count = echo_count_users();
            $category_count = echo_count_categories();
            ?>

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
                                    <div class='huge'><?php echo echo_count_post() ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
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
                                    <div class='huge'><?php echo echo_count_All_comments(); ?></div>
                                    <div>All Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
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
                                    <div class='huge'><?php echo $user_count; ?></div>
                                    <div>Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
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
                                    <div class='huge'><?php echo $category_count; ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
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
        </div>
        <!-- /.container-fluid -->

        <div class="row">
            <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],
                        ['Published Posts', <?php echo echo_count_published_post(); ?>],
                        ['Pending Posts', <?php echo echo_count_draft_post(); ?>],
                        ['Approved Comments', <?php echo $comment_count; ?>],
                        ['Pending Comments', <?php echo echo_count_pending_comments(); ?>],
                        ['Admin Users', <?php echo echo_count_admin_users(); ?>],
                        ['Sbscriber Users', <?php echo echo_count_subscriber_users(); ?>],
                        ['Categories', <?php echo $category_count; ?>]
                    ]);

                    var options = {
                        chart: {
                            title: 'Website Data',
                            subtitle: 'Posts, Comments, Users, and Categories',
                        }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            </script>
        </div>
    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>
</div>
