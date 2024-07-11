<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
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
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
            
            //move_uploaded_file($post_image_temp, "../hanyimage/$post_image");
            // Fetch the category title
            //$category_query = "SELECT * FROM categories WHERE id = {$comment_id}";
            //$select_categories_id = mysqli_query($connection, $category_query);
            
       

            echo "<tr>";
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_email</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_status</td>";
            //echo "<td><img width='100' src='../hanyimage/$post_image' alt='image' /></td>";
           // echo "<td>$post_tags</td>";                                                                       
           // echo "<td>$post_comment_count</td>";
            echo "<td>$comment_date</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id='>Approve</a></td>";
            echo "<td><a href='posts.php?delete='>UN Approved</a></td>";
            echo "<td><a href='posts.php?delete='>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php 
if (isset($_GET['delete'])) {
    $post_id_to_delete = $_GET['delete'];
    deleteposts($post_id_to_delete);
}
?>
