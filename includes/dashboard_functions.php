<?php

/////////////////////////////////// dashboard_posts////////////////////////////////////////////////////// 

function echo_count_post() {
    global $connection;
    $query = "SELECT * FROM posts";
    $select_all_posts_query = mysqli_query($connection, $query);
    $post_count = mysqli_num_rows($select_all_posts_query);
    return $post_count;
}



function echo_count_published_post() {
    global $connection;
    $query = "SELECT * FROM `posts` WHERE post_status IN ('published')";
    $select_all_published_posts_query = mysqli_query($connection, $query);
    $post_count = mysqli_num_rows($select_all_published_posts_query);
    return $post_count;
}





function echo_count_draft_post() {
    global $connection;
    $query = "SELECT * FROM `posts` WHERE post_status NOT IN ('published')";
    $select_all_draft_posts_query = mysqli_query($connection, $query);
    $draft_post_count = mysqli_num_rows($select_all_draft_posts_query);
    return $draft_post_count;
}


/////////////////////////////////////////////////  dashboard_posts////////////////////////////////////////////////////// 
////////////////////////////////////// 
///////////////////////////////////// END///////////////////////////////




/////////////////////////////////////////////////////////////////////////// comments////////////////////////////////////////////

function echo_count_All_comments() {
    global $connection;
    $query = "SELECT * FROM comments";
    $select_all_comments_query = mysqli_query($connection, $query);
    $comment_count = mysqli_num_rows($select_all_comments_query);
    return $comment_count;
}







function echo_count_comments() {
    global $connection;
    $query = "SELECT * FROM comments where comment_status=('approved')";
    $select_approved_comments_query = mysqli_query($connection, $query);
    $comment_count = mysqli_num_rows($select_approved_comments_query);
    return $comment_count;
}



function echo_count_pending_comments() {
    global $connection;
    $query = "SELECT * FROM comments where comment_status=('unapproved')";
    $select_unapproved_comments_query = mysqli_query($connection, $query);
    $comment_count = mysqli_num_rows($select_unapproved_comments_query);
    return $comment_count;
}


/////////////////////////////////////////////////////////////////////////////////////// comments////////////////////////////////////////////
/////////////////////////////////////////////
////////////////////////////END///////////////////




////////////////////////////////////////////////////////// USERS ////////////////////////////////



function echo_count_users() {
    global $connection;
    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);
    $user_count = mysqli_num_rows($select_all_users_query);
    return $user_count;
}


function echo_count_admin_users() {
    global $connection;
    $query = "SELECT * FROM users where user_role = 'admin'";
    $select_all_admin_users_query = mysqli_query($connection, $query);
    $user_count = mysqli_num_rows($select_all_admin_users_query);
    return $user_count;
}



function echo_count_subscriber_users() {
    global $connection;
    $query = "SELECT * FROM users where user_role = 'subscriber'";
    $select_all_subscriber_users_query = mysqli_query($connection, $query);
    $user_count = mysqli_num_rows($select_all_subscriber_users_query);
    return $user_count;
}







////////////////////////////////
///////////////////////
/////////////////////// END USERS ////////////////////////////////








///////////////////////////////////
function echo_count_categories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);
    $category_count = mysqli_num_rows($select_all_categories_query);
    return $category_count;
}






?>
