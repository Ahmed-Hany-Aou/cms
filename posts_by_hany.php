<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Post Content Column -->
        <div class="col-md-8">
            <?php
            global $connection;

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
                    <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                    <hr>
                    <!-- Post Content -->
                    <p class="lead"><?php echo $post_content; ?></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!</p>
                    <hr>
            <?php
                }
            }
            ?>
            <!-- Blog Comments -->
            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                echo $comment_author;

                // Construct the query
                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                $query .= "VALUES ($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";

                // Execute the query
                $insert_comments_query = mysqli_query($connection, $query);

                // Check if the query was successful
                if (!$insert_comments_query) {
                    die("Query failed: " . mysqli_error($connection));
                }
            }
            ?>

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

            <hr>
<?php include  "includes/comments.php"; ?>
                </div>
            </div>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        
            <?php include "includes/sidebar.php"; ?>
        
    </div>
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
