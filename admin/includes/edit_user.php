<?php
if (isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        $user_password = $row['user_password'];
    }
}

if (isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    // Hash the password only if provided
    if (!empty($user_password)) {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        // Update query with new password
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = {$the_user_id}";
    } else {
        // Update query without new password
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}' ";
        $query .= "WHERE user_id = {$the_user_id}";
    }

    $update_user = mysqli_query($connection, $query);
    confirm_Connection($update_user);
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="category">First Name</label>
        <input value="<?php echo isset($user_firstname) ? $user_firstname : ''; ?>" type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="category">Last Name</label>
        <input value="<?php echo isset($user_lastname) ? $user_lastname : ''; ?>" type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="category">Username</label>
        <input value="<?php echo isset($username) ? $username : ''; ?>" type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="category">Role</label>
        <select class="form-control" name="user_role">
            <option value="<?php echo isset($user_role) ? $user_role : 'select_option'; ?>"><?php echo isset($user_role) ? ucfirst($user_role) : 'Select Option'; ?></option>
            <?php
            if (isset($user_role) && $user_role == 'admin') {
                echo "<option value='subscriber'>Subscriber</option>";
            } else {
                echo "<option value='admin'>Admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="category">Email</label>
        <input value="<?php echo isset($user_email) ? $user_email : ''; ?>" type="text" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="category">Password</label>
        <input type="password" class="form-control" name="user_password" placeholder="Enter new password if you want to change it">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>
</form>
