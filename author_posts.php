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
            if (isset($_GET['author'])) {
                $the_post_author = $_GET['author'];
                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}'";
                $posts_query = mysqli_query($connection, $query);

                if (!$posts_query) {
                    die("Query failed: " . mysqli_error($connection));
                }

                while ($row = mysqli_fetch_assoc($posts_query)) {
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 50);

                    // Get the author's name
                    $user_query = "SELECT username FROM users WHERE user_id = {$post_user}";
                    $user_result = mysqli_query($connection, $user_query);
                    $user_row = mysqli_fetch_assoc($user_result);
                    $username = $user_row['username'];
            ?>
                    <!-- Title -->
                    <h1><a href="posts_by_hany.php?p_id=<?php echo $row['post_id']; ?>"><?php echo $post_title; ?></a></h1>
                    <!-- Author -->
                    <p class="lead">by <a href="author_posts.php?author=<?php echo $post_user ?>"><?php echo $username; ?></a></p>
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
            
            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES ($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                    $insert_comments_query = mysqli_query($connection, $query);
                    confirm_Connection($insert_comments_query);

                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";
                    $update_comment_count = mysqli_query($connection, $query);
                    confirm_Connection($update_comment_count);
                } else {
                    echo "<p class='bg-danger'>Fields cannot be empty</p>"; 
                }
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
<script>
document.getElementById('commentForm').addEventListener('submit', function(event) {
    var author = document.querySelector('input[name="comment_author"]').value.trim();
    var email = document.querySelector('input[name="comment_email"]').value.trim();
    var comment = document.querySelector('textarea[name="comment_content"]').value.trim();

    if (author === "" || email === "" || comment === "") {
        alert('All fields are required!');
        event.preventDefault(); // Prevent the form from being submitted
    } else {
        alert("Comment added successfully and it will be approved by admin soon");
    }
});
</script>
</body>
</html>
