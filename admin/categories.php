<?php include "includes/admin_header.php"?>



    <div id="wrapper">
 <!-- Navigation -->
<?php include "includes/admin_navigation.php"?>

      

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">


                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">
                 
            <?php insert_categories();  ?>
    
    <form action="" method="post">
      <div class="form-group">
         <label for="cat-title">Add Category</label>
          <input type="text" class="form-control" name="cat_title">
      </div>
       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
      </div>

    </form>
        
    <?php 
        if(isset($_GET['edit'])){
            $cat_id=$_GET['edit'];
            include "includes/update_categories.php";
        }
    
    
    
    ?>







     </div> <!--  add cateogry form -->

     

     <div class="col-xs-6">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Title</th>
                <th>DELETE Function</th>
                <th>EDIT Functions</th>
            </tr>
        </thead>
        <tbody>
          

            
                    <!-- find all the categories -->
                   <?php findALLCategories(); ?>
                <?php deleteCategories(); ?> 

                    // delete query                    
                

                
               
     </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include('includes/admin_footer.php'); ?>