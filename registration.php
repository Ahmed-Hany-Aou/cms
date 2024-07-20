<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT randSalt FROM users";
    $select_randSalt_query = mysqli_query($connection, $query);
    if (!$select_randSalt_query) {
        die("Query Failed" . mysqli_error($connection));
    }
    $row = mysqli_fetch_array($select_randSalt_query);
    $salt = $row['randSalt'];
    $password = crypt($password, $salt);

    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
    $create_user_query = mysqli_query($connection, $query);
    if (!$create_user_query) {
        die("Query Failed" . mysqli_error($connection));
    }
}
?>

<!-- Page Content -->
<div class="container">
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <hr>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            var username = document.querySelector('input[name="username"]').value.trim();
            var email = document.querySelector('input[name="email"]').value.trim();
            var password = document.querySelector('input[name="password"]').value.trim();

            if (username === "" || email === "" || password === "") {
                alert('All fields are required!');
                event.preventDefault(); // Prevent the form from being submitted
            }
            else {
                alert('Registration successful!');
            }
        });
    </script>

<?php include "includes/footer.php"; ?>
