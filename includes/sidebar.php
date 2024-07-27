<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <?php
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection, $query);

        if (!$select_categories_sidebar) {
            die("Query failed: " . mysqli_error($connection));
        }
        ?>

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $category_id = $row['id'];
                        $category_title = $row['cat_title'];
                        echo "<li><a href='category.php?category=$category_id'>{$category_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include 'includes/widget.php' ?>
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
