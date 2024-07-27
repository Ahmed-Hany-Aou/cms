<?php
session_start();
include "db.php";
include "functions.php"; // Ensure this is included to use utility functions

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Escape user inputs for security
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    // Query the user by username
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        die("Query Failed: " . mysqli_error($connection));
    }

    // Fetch the user data
    $user_found = false;
    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $user_found = true;
    }

    if ($user_found && password_verify($password, $db_user_password)) {
        // Password is correct, start the session and redirect user
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin/index.php");
        exit;
    } else {
        // Invalid username or password
        header("Location: ../search.php?error=invalidcredentials");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="path/to/your/css/file.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post" id="login-form" autocomplete="on">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="current-password" required>
                    <span class="input-group-btn">
                        <button class="btn btn-default toggle-password" type="button">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </button>
                    </span>
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'invalidcredentials') {
            echo "<p class='bg-danger'>Invalid username or password. Please try again.</p>";
        }
        ?>
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
</body>
</html>
