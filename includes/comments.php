<?php
if (isset($the_post_id)) {
    $query = "SELECT * FROM comments WHERE comment_post_id={$the_post_id} AND comment_status='approved' ORDER BY comment_id DESC";
    $select_comment_query = mysqli_query($connection, $query);
    confirm_Connection($select_comment_query);

    $has_comments = mysqli_num_rows($select_comment_query) > 0;

    if ($has_comments) {
        while ($row = mysqli_fetch_assoc($select_comment_query)) {
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
?>
            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo htmlspecialchars($comment_author); ?>
                        <small><?php echo htmlspecialchars($comment_date); ?></small>
                    </h4>
                    <?php echo htmlspecialchars($comment_content); ?>
                </div>
            </div>
<?php
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
}
?>
