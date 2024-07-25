<?php
if (isset($_POST['create_post'])) {

    $post_title = escape($_POST['title']);
    $post_user = escape($_POST['post_user']);
    $post_category_id = ($_POST['post_category']);
    $post_status = ($_POST['post_status']);

    $post_image = ($_FILES['image']['name']);
    $post_image_temp = ($_FILES['image']['tmp_name']);

    $post_tags = ($_POST['post_tags']);
    $post_content = ($_POST['post_content']);
    $post_date = (date('d-m-y'));

    move_uploaded_file($post_image_temp, "../hanyimage/$post_image");

    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) ";
    $query .= "VALUES ({$post_category_id}, '{$post_title}', {$post_user}, now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
    $create_post_query = mysqli_query($connection, $query);

    confirm_Connection($create_post_query);
    $p_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>post with id: " . $p_id . " has been created successfully 
    <a href='../posts_by_hany.php?p_id={$p_id}'>View Post</a> OR <a href='posts.php'>Edit More Posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Post Category</label>
        <select class="form-control" name="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['id'];
                $cat_title = $row['cat_title'];

                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select class="form-control" name="post_user">
            <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                echo "<option value='{$user_id}'>{$username}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Select Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>
