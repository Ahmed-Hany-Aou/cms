
        <!-- Blog Sidebar Widgets Column -->
        <div class="col-md-4">

      


            <!-- Blog Search Well -->
            
            <div class="well">
                <h4>Blog Search</h4>
                <form action="search.php" method="post">
                <div class="input-group">
                    <input name="search"type="text" class="form-control">
                    <span class="input-group-btn">
                        <button name="submit" class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                </form>
             



                <!-- /.input-group -->
            </div>





            <!-- Blog Categories Well -->


            <div class="well">
            <?php 
                
                $query='select * from categories';
                $select_cateogries_sidebar =mysqli_query($connection,$query);

                
                ?>







                <h4>Blog Categories</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-unstyled">
                            <?php
                        while($row=mysqli_fetch_assoc($select_cateogries_sidebar)){
                    $cat_titlle=$row['cat_title'];
                echo "<li><a href='#'>{$cat_titlle}</a></li>";
                }
                ?>

                        </ul>
                    </div>
               
                </div>
                <!-- /.row -->
            </div>

       <!-- Side Widget Well -->
            <?php include 'includes/widget.php'?>

        </div>