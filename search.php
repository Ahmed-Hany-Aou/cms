<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            $per_page = 10;

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $page_1 = ($page - 1) * $per_page;

            $display_posts = true;  // Initialize a flag to control post display

            if (isset($_POST['submit']) || isset($_GET['search'])) {
                $search = isset($_POST['search']) ? $_POST['search'] : $_GET['search'];
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' LIMIT $page_1, $per_page";
                $search_query = mysqli_query($connection, $query);

                if (!$search_query) {
                    die("Query Failed: " . mysqli_error($connection));
                }

                $count_query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $find_count = mysqli_query($connection, $count_query);
                $total_results = mysqli_num_rows($find_count);
                $count = ceil($total_results / $per_page);

                if ($total_results == 0) {
                    echo "<h2 class='text-center' style='color: red; text-align: center; font-weight: bold;'>🚫 No posts found.</h2>";
                    $display_posts = false;  // Do not display posts if no results
                } else {
                    echo "<h2 class='text-center results-found'>Found $total_results results</h2>";
                    $posts_query = $search_query;  // Use the search results
                }
            } else {
                // Fetch all posts by default
                $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                $posts_query = mysqli_query($connection, $query);

                $count_query = "SELECT * FROM posts";
                $find_count = mysqli_query($connection, $count_query);
                $total_results = mysqli_num_rows($find_count);
                $count = ceil($total_results / $per_page);
            }

            // Loop through the results and display posts only if allowed
            if ($display_posts && isset($posts_query)) {
                while ($row = mysqli_fetch_assoc($posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 50);
                    $post_status = $row['post_status'];

                    if ($post_status !== 'published') {
                        echo "<h2 class='text-center' style='color: red; text-align: center; font-weight: bold;'>🚫 This post is not published yet.</h2>
                        <p class='text-center' style='color: grey; text-align: center;'>
                        Please <a href='http://localhost/dashboard/demo/CMS_TEMPLATE/admin/posts.php?source=edit_post&p_id=$post_id' style='color: blue;'>edit the post</a> for more details. <br>
                        <strong>Post ID:</strong> $post_id
                        </p>";
                    } else {
                        ?>
                        <!-- Displaying the Post -->
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2 class="<?php echo isset($_POST['submit']) || isset($_GET['search']) ? 'post-title-green' : ''; ?>">
                            <a href="posts_by_hany.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
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
                }
            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <?php
                // Previous button
                if ($page > 1) {
                    $prev_page = $page - 1;
                    echo "<li class='previous'><a href='search.php?page={$prev_page}&search={$search}'>&larr; Older</a></li>";
                }

                // Page numbers
                for ($i = 1; $i <= $count; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='search.php?page={$i}&search={$search}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='search.php?page={$i}&search={$search}'>{$i}</a></li>";
                    }
                }

                // Next button
                if ($page < $count) {
                    $next_page = $page + 1;
                    echo "<li class='next'><a href='search.php?page={$next_page}&search={$search}'>Newer &rarr;</a></li>";
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

<style>
    .active_link {
        font-weight: bold;
        color: red;
    }
    .post-title-green a {
        color: green;
    }
    .results-found {
        color: green;
        text-align: center;
        font-weight: bold;
    }
</style>
