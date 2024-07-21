<?php
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";

// Define how many results you want per page
$posts_per_page = 10;

// Find out the number of results stored in database
$query = "SELECT * FROM posts WHERE post_status = 'published'";
$find_count = mysqli_query($connection, $query);
$total_posts = mysqli_num_rows($find_count);

// Determine the number of pages required
$total_pages = ceil($total_posts / $posts_per_page);

// Determine which page number visitor is currently on
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Determine the sql LIMIT starting number for the results on the displaying page
$start_limit = ($page - 1) * $posts_per_page;

// Fetch the selected results from database
$query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $start_limit, $posts_per_page";
$posts_query = mysqli_query($connection, $query);
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            while ($row = mysqli_fetch_assoc($posts_query)) {
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
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <a href="posts_by_hany.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="hanyimage/<?php echo $post_image; ?>" alt="Hany's Image" style="width: 200px; height: 300;">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="posts_by_hany.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php
            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <?php
                // Display previous page link if not on the first page
                if ($page > 1) {
                    echo "<li class='previous'><a href='search.php?page=" . ($page - 1) . "'>&larr; Older</a></li>";
                }

                // Display page numbers
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<li class='active'><a href='search.php?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='search.php?page={$i}'>{$i}</a></li>";
                    }
                }

                // Display next page link if not on the last page
                if ($page < $total_pages) {
                    echo "<li class='next'><a href='search.php?page=" . ($page + 1) . "'>Newer &rarr;</a></li>";
                }
                ?>
            </ul>
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
