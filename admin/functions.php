<?php 

function insert_categories(){
    global $connection;


    if (isset($_POST['submit'])){
        $cat_title=$_POST['cat_title'];
     
        if($cat_title==''|| empty($cat_title)){
         echo "This field should not be empty";

        }else{
         $query="INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
         $create_category_query= mysqli_query($connection, $query);
        if(!$create_category_query){

         die('Query failed' . mysqli_error($connection));
        }
     }
 }
}


function findALLCategories(){
    global $connection;
    $query='select * from categories';
                    $select_cateogries =mysqli_query($connection,$query);
                    while($row=mysqli_fetch_assoc($select_cateogries)){
                    $id=$row['id'];
                    $cat_title=$row['cat_title'];
                    echo "<tr>";
                    echo "<tr>";
                    echo "<td>{$id}</td>";
                    echo "<td>{$cat_title}</td>";
                    echo "<td><a href='categories.php?delete={$id}'>Delete</a></td>";
                    echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";

                    echo "</tr";                
                }



}


function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id=$_GET['delete'];
        $query="delete from categories where id={$the_cat_id}";
        $delete_query=mysqli_query($connection,$query);
        header("Location: categories.php");
    }
}












?>