<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

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
            <a class="navbar-brand" href="/dashboard/demo/CMS_TEMPLATE/search.php?search=&page=1">HOME</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php 
                $query = 'SELECT * FROM categories LIMIT 5';
                $select_all_categories_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id = $row['id'];  // Fetching the category id
                    $cat_title = $row['cat_title'];
                    $active = (isset($_GET['category']) && $_GET['category'] == $cat_id) ? 'active' : '';
                    echo "<li class='{$active}'><a href='/dashboard/demo/CMS_TEMPLATE/category.php?category={$cat_id}'>{$cat_title}</a></li>";
                }
                ?>

                <?php
                $pageName = basename($_SERVER['PHP_SELF']);
                $activeClass = 'class="active"';
                ?>

                <?php
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                    echo '<li ' . ($pageName == 'index.php' ? $activeClass : '') . '><a href="/dashboard/demo/CMS_TEMPLATE/admin/index.php">Admin</a></li>';
                    if (isset($_GET['p_id'])) {
                        $p_id = $_GET['p_id'];
                        echo "<li " . ($pageName == 'posts.php' ? $activeClass : '') . "><a href='/dashboard/demo/CMS_TEMPLATE/admin/posts.php?source=edit_post&p_id={$p_id}'>Edit Post</a></li>";
                    }
                }
                ?>

                <li <?php echo ($pageName == 'registration.php' ? $activeClass : ''); ?>><a href="/dashboard/demo/CMS_TEMPLATE/registration.php">Registration</a></li>
                <li <?php echo ($pageName == 'login.php' ? $activeClass : ''); ?>><a href="/dashboard/demo/CMS_TEMPLATE/login.php">Login</a></li>
                <li <?php echo ($pageName == 'contact.php' ? $activeClass : ''); ?>><a href="/dashboard/demo/CMS_TEMPLATE/contact.php">Contact Us</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
