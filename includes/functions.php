<?php
function redirect($location) {
    header("Location: " . $location);
    exit;
}

function confirm_Connection($result) {
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function insert_categories() {
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == '' || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            confirm_Connection($create_category_query);
        }
    }
}

function findALLCategories() {
    global $connection;
    $query = 'SELECT * FROM categories';
    $select_cateogries = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_cateogries)) {
        $id = $row['id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE id = {$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function deleteposts() {
    global $connection;
    if (isset($_GET['delete'])) {
        $the_post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
}

function deleteComment($comment_id) {
    global $connection;
    $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
    $delete_comment_query = mysqli_query($connection, $query);
    confirm_Connection($delete_comment_query);
    header("Location: comments.php");
    exit();
}

function approveComment($comment_id) {
    global $connection;
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id}";
    $approve_comment_query = mysqli_query($connection, $query);
    confirm_Connection($approve_comment_query);
    header("Location: comments.php");
    exit();
}

function unapproveComment($comment_id) {
    global $connection;
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
    $unapprove_comment_query = mysqli_query($connection, $query);
    confirm_Connection($unapprove_comment_query);
    header("Location: comments.php");
    exit();
}

function show_comment($the_post_id) {
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
    $select_comment_query = mysqli_query($connection, $query);
    confirm_Connection($select_comment_query);

    $has_comments = mysqli_num_rows($select_comment_query) > 0;

    if ($has_comments) {
        while ($row = mysqli_fetch_assoc($select_comment_query)) {
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
            echo '<!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">' . htmlspecialchars($comment_author) . '
                        <small>' . htmlspecialchars($comment_date) . '</small>
                    </h4>
                    ' . htmlspecialchars($comment_content) . '
                </div>
            </div>';
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
}
?>