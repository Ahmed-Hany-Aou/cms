<?php 
if (isset($_GET['p_id'])){
   $p_id = $_GET['p_id'];
   echo $p_id;
}

//$query='select * from posts WHERE post_id = {$p_id}';
$query = "SELECT * FROM posts WHERE post_id = {$p_id}";
$select_posts_by_Id =mysqli_query($connection,$query);
while($row=mysqli_fetch_assoc($select_posts_by_Id )){
$post_id=$row['post_id'];
$post_author=$row['post_author'];
$post_title=$row['post_title'];
$post_cateogry_id=$row['post_cateogry_id'];
// $post_title=$row['post_title'];

$post_status=$row['post_status'];
$post_image=$row['post_image'];
$post_tags=$row['post_tags'];
$post_content=$row['post_content'];
$post_comment_count=$row['post_comment_count'];
 $post_date=$row['post_date'];

}
?>



<form action="" method="post" enctype="multipart/form-data">    
     
     
     <div class="form-group">
        <label for="title">Post Title</label>
         <input type="text" value="<?php  echo $post_title; ?>" class="form-control" name="title">


         <div class="form-group">
    <label for="category">Post Category</label>
    <select class="form-control" name="post_category">
        <?php
        // PHP code to fetch categories from the database
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        if (!$select_categories) {
            die("Query failed: " . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['id'];
            $cat_title = $row['cat_title'];

            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }

        // Release the query result
        mysqli_free_result($select_categories);
        ?>
    </select>
</div>
 
        
         <!--
        <div class="form-group">
      <label for="category">Post Category id</label>
      <input type="text" value="<?php//  echo $post_cateogry_id; ?>"  class="form-control" name="post_category_id">
     </div>
     
     --->

     <div class="form-group">
      <label for="category">Post author</label>
      <input type="text" value="<?php  echo $post_author; ?>" class="form-control" name="author">

      </div>





     <!-- <div class="form-group">
        <label for="title">Post Author</label>
         <input type="text" class="form-control" name="author">
     </div> -->
     
     

     <div class="form-group">
      <label for="category">Post Status</label>
      <input type="text" value="<?php  echo $post_status; ?>" class="form-control" name="post_status"> 
     </div>
     
     
     
 


     <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image">
    <img src="../hanyimage/<?php echo $post_image; ?>" alt="Post Image" width="100">
</div>





     <div class="form-group">
        <label for="post_tags">Post Tags</label>
         <input type="text" value="<?php  echo $post_tags; ?>" class="form-control" name="post_tags">
     </div>
     
     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"> <?php  echo $post_content; ?>
        </textarea>
     </div>
     
     

      <div class="form-group">
         <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
     </div>


</form>




 