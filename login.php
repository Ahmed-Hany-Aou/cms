<?php 
include "includes/db.php"; 
include "includes/header.php"; 
include "includes/functions.php";

// Redirect function to check if user is logged in
checkIfUserIsLoggedInAndRedirect('/dashboard/demo/CMS_TEMPLATE/admin/index.php');

// Check if the request method is POST
if(ifItIsMethod('post')) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        // Log in the user
        login_user($_POST['username'], $_POST['password']);
    } else {
        // Redirect to admin page if POST data is not set
        redirect('/dashboard/demo/CMS_TEMPLATE/admin/index.php');
    }
}
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">
                                <form id="login-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default toggle-password" type="button">
                                                    <span class="glyphicon glyphicon-eye-open"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                                    </div>
                                </form>
                            </div><!-- Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php include "includes/footer.php"; ?>
</div> <!-- /.container -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.querySelector('span').classList.toggle('glyphicon-eye-open');
        this.querySelector('span').classList.toggle('glyphicon-eye-close');
    });
});
</script>
