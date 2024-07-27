<?php include("functions.php");?>

<?php
if (ifItIsMethod('post')) {
    if (isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $login_successful = login_user($_POST['username'], $_POST['password']);
            if (!$login_successful) {
                track_failed_login_attempts();
            } else {
                reset_failed_login_attempts();
            }
        } else {
            redirect('index');
        }
    }
}
?>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form><!--search form-->
        <!-- /.input-group -->
    </div>

    <!--Login -->
    <div class="well">
        <?php if(isset($_SESSION['user_role'])): ?>
            <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                            <button class="btn btn-default toggle-password" type="button">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </div>

                <div class="form-group">
                    <?php display_forgot_password_link(); ?>
                </div>
            </form><!--search form-->
            <!-- /.input-group -->
        <?php endif; ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <?php 
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection, $query);         
        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php 
                    while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $id = $row['id'];
                        echo "<li><a href='category.php?category=$id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php //include "widget.php"; ?>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            var input = this.parentElement.previousElementSibling;
            var icon = this.querySelector('.glyphicon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('glyphicon-eye-open');
                icon.classList.add('glyphicon-eye-close');
            } else {
                input.type = "password";
                icon.classList.remove('glyphicon-eye-close');
                icon.classList.add('glyphicon-eye-open');
            }
        });
    });
</script>
