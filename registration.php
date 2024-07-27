<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<?php include "includes/functions.php"; ?>

<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if the username or email already exists
    $usernameExists = username_exists($username);
    $emailExists = email_exists($email);

    if ($usernameExists || $emailExists) {
        if ($usernameExists) {
            $message = 'Username already exists, please choose a different username.';
            echo "<script>alert('$message');</script>";
        }

        if ($emailExists) {
            $message = 'Email already exists, please choose a different email.';
            echo "<script>alert('$message');</script>";
        }
    } else {
        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
        $create_user_query = mysqli_query($connection, $query);

        if (!$create_user_query) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            echo "<script>alert('Registration successful!');</script>";
        }
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
                        <form role="form" action="registration.php" method="post" id="registration-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" minlength="5" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" minlength="8" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="sr-only">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" minlength="8" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default toggle-password" type="button">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <input type="submit" name="submit" id="btn-register" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

    <script>
        document.getElementById('registration-form').addEventListener('submit', function(event) {
            var username = document.querySelector('input[name="username"]').value.trim();
            var email = document.querySelector('input[name="email"]').value.trim();
            var password = document.querySelector('input[name="password"]').value.trim();
            var confirmPassword = document.querySelector('input[name="confirm_password"]').value.trim();

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var errorMessage = "";

            if (username === "" || email === "" || password === "" || confirmPassword === "") {
                errorMessage += "All fields are required.\n";
            } 
            if (username.length < 5) {
                errorMessage += "Username must be at least 5 characters long.\n";
            }
            if (password.length < 8) {
                errorMessage += "Password must be at least 8 characters long.\n";
            }
            if (!/[A-Z]/.test(password)) {
                errorMessage += "Password must contain at least one uppercase letter.\n";
            }
            if (!/\d/.test(password)) {
                errorMessage += "Password must contain at least one number.\n";
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                errorMessage += "Password must contain at least one special character.\n";
            }
            if (password !== confirmPassword) {
                errorMessage += "Passwords do not match.\n";
            }
            if (!emailPattern.test(email)) {
                errorMessage += "Invalid email format.\n";
            }

            if (errorMessage !== "") {
                alert(errorMessage.trim());
                event.preventDefault(); // Prevent the form from being submitted
            }
        });

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

<?php include "includes/footer.php"; ?>
