<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Author</th>
                                        <th>Tiltle</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Tags</th>
                                        <th>Comments</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            <tbpdy>
                               
                                <?php 
                                
                                
                                $query='select * from posts';
                    $select_posts =mysqli_query($connection,$query);
                    while($row=mysqli_fetch_assoc($select_posts)){
                    $post_id=$row['post_id'];
                    $post_author=$row['post_author'];
                    $post_title=$row['post_title'];
                    $post_cateogry_id=$row['post_cateogry_id'];
                   // $post_title=$row['post_title'];
                    
                    $post_status=$row['post_status'];
                    $post_image=$row['post_image'];
                    $post_tags=$row['post_tags'];
                    $post_comment_count=$row['post_comment_count'];
                     $post_date=$row['post_date'];
                 //   $post_content=$row['post_content'];
                   // d	Author	Tiltle	Category	Status	Image	Tags	Comments	Da
                        echo "<tr>";
                        echo "<td>$post_id</td>";
                        echo "<td>$post_author</td>";
                        echo "<td>$post_title</td>";
                        echo "<td>$post_cateogry_id</td>";
                        echo "<td>$post_status</td>";
                        //echo "<td>$post_image </td>";
                        echo "<td><img width='100' src='../hanyimage/$post_image' alt='image' /></td>";
                        echo "<td>$post_tags</td>";                                                                       
                       echo "<td>$post_comment_count</td>";
                        echo "<td>$post_date</td>";
                       echo "<td><a href='posts.php?delete={$post_id}'>Delete<a/></td>";

                        echo "</tr>";
                
                
                }
                                ?>

            <!-- if (isset($_GET['delete'])) {
    ...
}
-->
<?php 
deleteposts();
?>

                                    <td>10</td>
                                    <td>hany</td>
                                    <td>booststrap frame work</td>
                                    <td>booststrap</td>
                                    <td>Status</td>
                                    <td>Image</td>
                                    <td>Tags</td>
                                    <td>Comments</td>
                                    <th>Date</th>
                            
                            </tbpdy>
                            </table>
               