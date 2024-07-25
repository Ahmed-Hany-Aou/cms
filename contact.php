<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
if (isset($_POST["submit"])) {
    $to = "support@Ahmed.com";
    $subject = $_POST['subject'];
    $body = $_POST['body'];
   

}
?>

<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Your Name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject Here">
                            </div>
                            <div class="form-group">
                                <label for="message" class="sr-only">Message</label>
                                <textarea class="form-control" name="message" id="summernote" cols="30" rows="10" placeholder="Enter Your Message Here"></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>

    <!-- Include jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Include Summernote CSS -->
    <link href="cs_template/admin/css/summernote.css" rel="stylesheet">
    <!-- Include Summernote JS -->
    <script src="cs_template/admin/js/summernote.js"></script>

    <!-- Initialize Summernote -->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 200 // set the height of the editor
            });
        });
    </script>

<?php include "includes/footer.php"; ?>
