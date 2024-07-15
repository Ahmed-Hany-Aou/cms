<?php include "includes/admin_header.php"?>
<?php 
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_user_profile_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password= $row ['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role=$row['user_role'];

    }

}







?>


    <div id="wrapper">
 <!-- Navigation -->
<?php include "includes/admin_navigation.php"?>

      

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                 
                        <h1 class="page-header">
                            Welcome to admin
                            <small> Author</small>
                            </h1>

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
        <input value="<?php echo isset($user_password) ? $user_password : ''; ?>" type="text" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
    </div>
</form>
                            
        
                            
                            
                            





     </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include('includes/admin_footer.php'); ?>