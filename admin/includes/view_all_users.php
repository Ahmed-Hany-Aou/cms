<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Fierst Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
          
            
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM users";
        $select_comments = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_comments)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td>$username</td>";
            echo "<td>$user_firstname</td>";
            echo "<td>$user_lastname</td>";
            echo "<td>$user_email</td>";

            // Fetch the related post title

            /*
           $post_query = "SELECT post_title FROM posts WHERE post_id = {$comment_post_id}";
           $select_post_id_query = mysqli_query($connection, $post_query);
           if ($post_row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_title = $post_row['post_title'];
                echo "<td><a href='../posts_by_hany.php?p_id=$comment_post_id'>$post_title</a></td>";
            } else {
                echo "<td>Post Not Found</td>";
            }
            */
            echo "<td>$user_role</td>";

            echo "<td><a href='comments.php?approve='>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove='>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete='>Delete</a></td>";
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
