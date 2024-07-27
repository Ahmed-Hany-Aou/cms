<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("db.php");

function track_failed_login_attempts() {
    if (!isset($_SESSION['failed_login_attempts'])) {
        $_SESSION['failed_login_attempts'] = 0;
    }
    $_SESSION['failed_login_attempts']++;
}

function reset_failed_login_attempts() {
    $_SESSION['failed_login_attempts'] = 0;
}

function display_forgot_password_link() {
    if (isset($_SESSION['failed_login_attempts']) && $_SESSION['failed_login_attempts'] >= 2) {
        echo '<a href="forgot.php?forgot=' . uniqid(true) . '">Forgot Password</a>';
    }
}


function login_user($username, $password) {
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    if (password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        redirect("/dashboard/demo/CMS_TEMPLATE/admin/index.php"); // Updated redirect URL
    } else {
        return false;
    }
}

function redirect($location) {
    header("Location:" . $location);
    exit;
}

function ifItIsMethod($method = null) {
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn() {
    if (isset($_SESSION['user_role'])) {
        return true;
    }
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation = null) {
    if (isLoggedIn()) {
        redirect($redirectLocation);
    }
}

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function online_users() {
    global $connection;

    $session = session_id();
    $time = time();
    $time_out_in_seconds = 20;
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    if ($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    $count_user = mysqli_num_rows($users_online_query);

    echo $count_user;
}

if (isset($_GET['onlineusers'])) {
    online_users();
}

function confirm_Connection($result) {
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function insert_categories() {
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == '' || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            confirm_Connection($create_category_query);
        }
    }
}

function findALLCategories() {
    global $connection;
    $query = 'SELECT * FROM categories';
    $select_cateogries = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_cateogries)) {
        $id = $row['id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories() {
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE id = {$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function deleteposts($post_id) {
    global $connection;
    $query = "DELETE FROM posts WHERE post_id = {$post_id}";
    $delete_query = mysqli_query($connection, $query);
    confirm_Connection($delete_query);
    header("Location: posts.php");
}

function deleteComment($comment_id) {
    global $connection;
    $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
    $delete_comment_query = mysqli_query($connection, $query);
    confirm_Connection($delete_comment_query);
    header("Location: comments.php");
    exit();
}

function approveComment($comment_id) {
    global $connection;
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$comment_id}";
    $approve_comment_query = mysqli_query($connection, $query);
    confirm_Connection($approve_comment_query);
    header("Location: comments.php");
    exit();
}

function unapproveComment($comment_id) {
    global $connection;
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$comment_id}";
    $unapprove_comment_query = mysqli_query($connection, $query);
    confirm_Connection($unapprove_comment_query);
    header("Location: comments.php");
    exit();
}

function show_comment($the_post_id) {
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
    $select_comment_query = mysqli_query($connection, $query);
    confirm_Connection($select_comment_query);

    $has_comments = mysqli_num_rows($select_comment_query) > 0;

    if ($has_comments) {
        while ($row = mysqli_fetch_assoc($select_comment_query)) {
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
            echo '<!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">' . htmlspecialchars($comment_author) . '
                        <small>' . htmlspecialchars($comment_date) . '</small>
                    </h4>
                    ' . htmlspecialchars($comment_content) . '
                </div>
            </div>';
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
}

function is_admin($username = '') {
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_Connection($result);
    $row = mysqli_fetch_assoc($result);
    if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

function username_exists($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_Connection($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function email_exists($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirm_Connection($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
?>
