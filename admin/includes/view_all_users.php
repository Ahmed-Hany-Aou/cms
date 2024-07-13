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

            echo "<td><a href='user.php?change_to_admin=$user_id'>Admin</a></td>";
            echo "<td><a href='user.php?change_to_sub=$user_id'>Subscriber</a></td>";
            echo "<td><a href='user.php?source=edit_user&edit_user=$user_id'>Edit</a></td>";
            echo "<td><a href='user.php?delete=$user_id'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php 
if (isset($_GET['delete'])) {
    $user_id_to_delete = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id = {$user_id}";
    $delete_user_query = mysqli_query($connection, $query);
    if (!$delete_user_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: user.php"); // Redirect to the comments page after deletion
}

if (isset($_GET['change_to_admin'])) {
    $user_id_to_admin = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$user_id_to_admin}";
    $change_admin_query = mysqli_query($connection, $query);
    if (!$change_admin_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: user.php"); // Redirect to the comments page after approval
}

if (isset($_GET['change_to_sub'])) {
    $user_id_to_sub = $_GET['change_to_sub'];
    $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = {$user_id_to_sub}";
    $change_sub_query = mysqli_query($connection, $query);
    if (!$change_sub_query) {
        die("Query failed: " . mysqli_error($connection));
    }
    header("Location: user.php"); // Redirect to the comments page after unapproval
}
?>
