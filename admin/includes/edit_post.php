<?php
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    
}

if (isset($_POST['Update_Post'])) {
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];

    // Check if a new image has been uploaded
    if (empty($post_image)) {
        $post_image = $_POST['current_image'];
    } else {
        move_uploaded_file($post_image_temp, "../hanyimage/$post_image");
    }

    // Update query
    $query = "UPDATE posts SET ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_image = '{$post_image}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_date = now() ";
    $query .= "WHERE post_id = {$p_id}";

    $update_post = mysqli_query($connection, $query);
    confirm_Connection($update_post);

    echo "<p class='bg-success'>post with id:".$p_id." has been updated successfully 
    <a href='../posts_by_hany.php?p_id={$p_id}'>View Post <a/> OR <a href='posts.php'>Edit More Posts</a> </p>"; 

}

$query = "SELECT * FROM posts WHERE post_id = {$p_id}";
$select_posts_by_Id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts_by_Id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id']; // Make sure this matches the database column name
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
}
?>


<form action="" method="post" enctype="multipart/form-data">    
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Post Category</label>
        <select class="form-control" name="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            if (!$select_categories) {
                die("Query failed: " . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['id'];
                $cat_title = $row['cat_title'];

                // Select the current category
                if ($cat_id == $post_category_id) {
                    echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }

            mysqli_free_result($select_categories);
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="author">
    </div>



    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select type="text" value="<?php echo $post_status; ?>" class="form-control" name="post_status">
        <option value="<?php echo isset($post_status) ? $post_status : 'select_option'; ?>"><?php echo isset($post_status) ? ucfirst($post_status) : 'Select Option'; ?></option>
            <?php
            if (isset($post_status) && $post_status == 'published') {
                echo "<option value='draft'>Draft</option>";
            } else {
                echo "<option value='published'>Published</option>";
            }
            ?>
            </select>
    </div>





    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
        <img src="../hanyimage/<?php echo $post_image; ?>" alt="Post Image" width="100">
        <input type="hidden" name="current_image" value="<?php echo $post_image; ?>">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="Update_Post" value="Update Post">
    </div>
</form>
