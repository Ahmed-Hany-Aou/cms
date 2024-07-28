<?php 
include "includes/db.php"; 
include "includes/header.php"; 
include "includes/functions.php";

if (ifItIsMethod('get') && isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $stmt = mysqli_prepare($connection, "SELECT username FROM users WHERE user_email=? AND token=?");
    mysqli_stmt_bind_param($stmt, 'ss', $email, $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        if (ifItIsMethod('post') && isset($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 12));

            $stmt = mysqli_prepare($connection, "UPDATE users SET user_password='{$password}', token='' WHERE user_email=?");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) >= 1) {
                redirect('/dashboard/demo/CMS_TEMPLATE/login.php');
            }
        }
    } else {
        redirect('/dashboard/demo/CMS_TEMPLATE/login.php');
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
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>Enter your new password below.</p>
                            <div class="panel-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="New Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="reset-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
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
