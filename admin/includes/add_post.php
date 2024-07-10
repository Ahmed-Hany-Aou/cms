<?php
   

   if(isset($_POST['create_post'])) {
   
            $post_title  = ($_POST['title']);
            $post_author = ($_POST['author']); 
          //  $post_user         = ($_POST['post_user']);
        //  $post_category_id  = ($_POST['post_category_id']);
            $post_status       = ($_POST['post_status']);
    
            $post_image        = ($_FILES['image']['name']);
            $post_image_temp   = ($_FILES['image']['tmp_name']);
    
    
            $post_tags         = ($_POST['post_tags']);
            $post_content      = ($_POST['post_content']);
            $post_date         = (date('d-m-y'));
            $post_comment_count= 4;
       
        move_uploaded_file($post_image_temp, "../hanyimage/$post_image" );

   
     $query = "INSERT INTO posts (/*post_category_id,*/ post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
     $query .= "VALUES ('{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";
         $create_post_query= mysqli_query($connection,$query);

       confirm_Connection($create_post_query);
   }

        ?>

    <form action="" method="post" enctype="multipart/form-data">    
     
     
      <div class="form-group">
         <label for="title">Post Title</label>
          <input type="text" class="form-control" name="title">




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











          <!--
         <div class="form-group">
       <label for="category">Post Category id</label>
       <input type="text" class="form-control" name="post_category_id">
      </div>
      -->

      <div class="form-group">
       <label for="category">Post author</label>
       <input type="text" class="form-control" name="author">
       </div>





      <!-- <div class="form-group">
         <label for="title">Post Author</label>
          <input type="text" class="form-control" name="author">
      </div> -->
      
      

      <div class="form-group">
       <label for="category">Post Status</label>
       <input type="text" class="form-control" name="post_status"> 
      </div>
      
      
      
    <div class="form-group">
         <label for="post_image">Post Image</label>
          <input type="file"  name="image">
      </div>

      <div class="form-group">
         <label for="post_tags">Post Tags</label>
          <input type="text" class="form-control" name="post_tags">
      </div>
      
      <div class="form-group">
         <label for="post_content">Post Content</label>
         <textarea class="form-control "name="post_content" id="" cols="30" rows="10">
         </textarea>
      </div>
      
      

       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
      </div>


</form>
    