<?php 
include "includes/db.php"; 
include "includes/header.php"; 
include "includes/functions.php"; 

echo "Starting forgot password script...<br>";

if (ifItIsMethod('post')) {
    echo "Form method is POST...<br>";
    if (isset($_POST['email'])) {
        echo "Email is set...<br>";
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        echo "Generated token: $token<br>";

        if (email_exists($email)) {
            echo "Email exists in database...<br>";
            $stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email=?");
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo "Updated user with token...<br>";

            // Create the email body
            $subject = "Reset your password";
            $body = "Please click the link below to reset your password:
                    <a href='http://localhost/dashboard/demo/CMS_TEMPLATE/reset.php?email={$email}&token={$token}'>http://localhost/dashboard/demo/CMS_TEMPLATE/reset.php?email={$email}&token={$token}</a>";

            echo "Email body created...<br>";

            // Send email
            sendMail($email, $subject, $body);

            echo "Mail sent...<br>";

            $emailSent = true;
        } else {
            echo "This email does not exist.<br>";
        }
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
                            <?php if(!isset($emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" type="email" class="form-control" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                    </form>
                                </div><!-- Body-->
                            <?php else: ?>
                                <h3>Please check your email for a password reset link.</h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <?php include "includes/footer.php"; ?>
</div> <!-- /.container -->
