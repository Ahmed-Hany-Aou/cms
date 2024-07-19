<form action="" method='post'>

<table class="table table-bordered table-hover">
<div id="bulkOptionContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options" id="bulk_options">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="add_post.php">Add New</a>
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
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $query = "SELECT * FROM posts";
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
            
          
     

            //move_uploaded_file($post_image_temp, "../hanyimage/$post_image");
            // Fetch the category title
            $category_query = "SELECT * FROM categories WHERE id = {$post_cateogry_id}";
            $select_categories_id = mysqli_query($connection, $category_query);
            
            if ($category_row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_title = $category_row['cat_title'];
            } else {
                $cat_title = "Uncategorized"; // Default value if category not found
            }

            echo "<tr>";
            ?>
            <td><input class='checkbox' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'  ></td>
            
            <?php
            echo "<td>$post_id</td>";
            echo "<td>$post_author</td>";
            echo "<td>$post_title</td>";
            echo "<td>$cat_title</td>";
            echo "<td>$post_status</td>";
            echo "<td><img width='100' src='../hanyimage/$post_image' alt='image' /></td>";
            echo "<td>$post_tags</td>";                                                                       
            echo "<td>$post_comment_count</td>";
            echo "<td>$post_date</td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
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
