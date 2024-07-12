<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            $display_posts = true;  // Initialize a flag to control post display

            if (isset($_POST['submit'])) {
                $search = $_POST['search'];
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query = mysqli_query($connection, $query);

                if (!$search_query) {
                    die("Query Failed: " . mysqli_error($connection));
                }

                $count = mysqli_num_rows($search_query);
                if ($count == 0) {
                    echo "<h1>No Results</h1>";
                    $display_posts = false;  // Do not display posts if no results
                } else {
                    $posts_query = $search_query;  // Use the search results
                }
            } else {
                // Fetch all posts by default
                $query = "SELECT * FROM posts";
                $posts_query = mysqli_query($connection, $query);
            }

            // Loop through the results and display posts only if allowed
            if ($display_posts && isset($posts_query)) {
                while ($row = mysqli_fetch_assoc($posts_query)) {
                    $post_id= $row ['post_id'];
                    $post_title = $row['post_title'];
                
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content =substr( $row['post_content'],0,50);
                    ?>
                    <!-- Displaying the Post -->
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>



                    <?php
        //video 122
        if(isset($_GET['p_id'])){
           $post_id = $_GET['p_id'];
        }
        
        ?>

                    <!-- First Blog Post -->
                    <h2>
                    <a href="posts_by_hany.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?></a>
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
            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
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
