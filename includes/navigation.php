
<?php session_start(); ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="search.php?search=&page=1">HOME</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">


                <?php 
                
                $query='select * from categories LIMIT 5';
                $select_all_cateogries_query =mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($select_all_cateogries_query)){
                    $cat_titlle=$row['cat_title'];
                echo "<li><a href='#'>{$cat_titlle}</a></li>";
                }
                ?>
                <?php

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    echo '<li><a href="admin/index.php">Admin</a></li>';
                    if (isset($_GET['p_id'])) {
                        $p_id = $_GET['p_id'];
                    echo "<li><a href='admin/posts.php?source=edit_post&p_id={$p_id}'>Edit Post</a></li>";
                }
            }

                ?>


                            
            

           

               
                <li>  <a href="./registration.php">Registration</a></li>
                <li>  <a href="./contact.php">Contact Us</a></li>
                    
                </li>
                <!--
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                -->

            



            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>