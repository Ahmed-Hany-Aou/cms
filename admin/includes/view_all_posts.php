<?php 
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_published_status = mysqli_query($connection, $query);
                confirm_Connection($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirm_Connection($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirm_Connection($update_to_delete_status);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    $post_tags = $row['post_tags'];
                    $post_status = $row['post_status'];
                }

                $query = "INSERT INTO posts (post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES ('{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

                $create_post_query = mysqli_query($connection, $query);
                confirm_Connection($create_post_query);

                break;

                case 'reset_posts_views':
                $query = "UPDATE posts SET posts_views_count = 0 WHERE post_id = {$postValueId}";
                $update_to_reset_views = mysqli_query($connection, $query);
                confirm_Connection($update_to_reset_views);
                break;


        }
    }
}
?>

<form action="" method='post'>
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="bulk_options">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone/Copy</option>
                <option value="reset_posts_views">Reset Posts Views</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Posts_Views</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = "SELECT * FROM posts order by post_id desc";
            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_cateogry_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                $post_views_count = $row['posts_views_count'];

                // Fetch the category title
                $category_query = "SELECT * FROM categories WHERE id = {$post_cateogry_id}";
                $select_categories_id = mysqli_query($connection, $category_query);

                if ($category_row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_title = $category_row['cat_title'];
                } else {
                    $cat_title = "Uncategorized";
                }

                echo "<tr>";
                ?>
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
                <?php
                echo "<td>$post_id</td>";
                echo "<td>$post_author</td>";
                echo "<td>$post_title</td>";
                echo "<td>$cat_title</td>";
                echo "<td>$post_status</td>";
                echo "<td><img width='100' src='../hanyimage/$post_image' alt='image' /></td>";
                echo "<td>$post_tags</td>";

                $query = "select * from comments where comment_post_id= $post_id";
                $select_comment_query = mysqli_query($connection, $query);
                $comment_count = mysqli_num_rows($select_comment_query);



                echo "<td>$comment_count</td>";
                echo "<td>$post_date</td>";
                echo "<td>$post_views_count</td>";
                echo "<td><a href='../posts_by_hany.php?p_id={$post_id}'>View Post</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post ?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>

<?php 
if (isset($_GET['delete'])) {
    $post_id_to_delete = $_GET['delete'];
    deleteposts($post_id_to_delete);
}
?>
