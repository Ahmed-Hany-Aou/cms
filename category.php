<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['category'])) {
                $cat_id = $_GET['category'];

                $query = "SELECT * FROM posts WHERE post_category_id = {$cat_id}";
                if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
                    $query .= " AND post_status = 'published'";
                }

                $select_posts_by_category = mysqli_query($connection, $query);

                if (!$select_posts_by_category) {
                    die("Query failed: " . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_posts_by_category) > 0) {
                    while ($row = mysqli_fetch_assoc($select_posts_by_category)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'], 0, 50);
                        ?>
                        <!-- Displaying the Post -->
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="posts_by_hany.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="hanyimage/<?php echo $post_image; ?>" alt="Hany's Image" style="width: 200px; height: 300;">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                        <?php
                    }
                } else {
                    echo "<h2 class='text-center' style='color: red; text-align: center; font-weight: bold;'>🚫 No posts available in this category.</h2>";
                }
            } else {
                echo "<h2 class='text-center' style='color: red; text-align: center; font-weight: bold;'>🚫 No category selected.</h2>";
            }
            ?>
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
