<?php include "db.php"; ?>
<?php session_start(); ?>

<?php
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
        die("Query Failed" . mysqli_error($connection));
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

<!-- HTML code for the login form -->
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
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <?php
        if (isset($_GET['error']) && $_GET['error'] === 'invalidcredentials') {
            echo "<p class='bg-danger'>Invalid username or password. Please try again.</p>";
        }
        ?>
    </div>
</body>
</html>
