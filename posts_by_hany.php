<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/functions.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Post Content Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];
                $query = "SELECT * FROM posts WHERE post_id = $post_id";
                $posts_query = mysqli_query($connection, $query);

                if (!$posts_query) {
                    die("Query failed: " . mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($posts_query)) {
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 50);
            ?>
                    <!-- Title -->
                    <h1><a href="posts_by_hany.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h1>
                    <!-- Author -->
                    <p class="lead">by <a href="#"><?php echo $post_author; ?></a></p>
                    <hr>
                    <!-- Date/Time -->
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <!-- Preview Image -->
                    <img class="img-responsive" src="hanyimage/<?php echo $post_image; ?>" alt="Hany's Image" style="width: 200px; height: 300;">
                    <hr>
                    <!-- Post Content -->
                    <p class="lead"><?php echo $post_content; ?></p>
            <?php
                }
            }
            ?>

            <!-- Blog Comments -->
            

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="Author">Author</label>
                        <input type="text" class="form-control" name="comment_author" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="Author">Email</label>
                        <input type="email" class="form-control" name="comment_email" placeholder="Enter your Email">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea class="form-control" rows="3" name="comment_content" placeholder="Enter your comment"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                // Construct the query
                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                $query .= "VALUES ($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";

                // Execute the query
                $insert_comments_query = mysqli_query($connection, $query);

                // Check if the query was successful
                confirm_Connection($insert_comments_query);


                $query= "update posts set post_comment_count = post_comment_count +1 where post_id = $the_post_id";
                $update_comment_count = mysqli_query($connection, $query);
            

            }


            // Display comments
            if (isset($post_id)) {
                $the_post_id = $post_id;
                include "includes/comments.php";
            }
            ?>



            <hr>
        </div>


<!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"; ?>
<!-- /.row -->
<hr>
<!-- Footer -->
<?php include "includes/footer.php"; ?>
</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
