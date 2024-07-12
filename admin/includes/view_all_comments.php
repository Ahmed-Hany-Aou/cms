<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Comment</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Date</th>
            <th>Approved</th>
            <th>UN Approved</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM comments";
        $select_comments = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_comments)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_status</td>";

            // Fetch the related post title
            $post_query = "SELECT post_title FROM posts WHERE post_id = {$comment_post_id}";
            $select_post_id_query = mysqli_query($connection, $post_query);
            if ($post_row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_title = $post_row['post_title'];
                echo "<td><a href='../posts_by_hany.php?p_id=$comment_post_id'>$post_title</a></td>";
            } else {
                echo "<td>Post Not Found</td>";
            }

            echo "<td>$comment_date</td>";
            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php 
if (isset($_GET['delete'])) {
    $comment_id_to_delete = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id = {$comment_id_to_delete}";
    $delete_comment_query = mysqli_query($connection, $query);
    if (!$delete_comment_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: comments.php"); // Redirect to the comments page after deletion
}

if (isset($_GET['approve'])) {
    $comment_id_to_approve = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id_to_approve}";
    $approve_comment_query = mysqli_query($connection, $query);
    if (!$approve_comment_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: comments.php"); // Redirect to the comments page after approval
}

if (isset($_GET['unapprove'])) {
    $comment_id_to_unapprove = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id_to_unapprove}";
    $unapprove_comment_query = mysqli_query($connection, $query);
    if (!$unapprove_comment_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: comments.php"); // Redirect to the comments page after unapproval
}
?>
