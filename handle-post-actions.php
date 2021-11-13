<?php

require_once 'config/init.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST['action'];
    $page = $_POST['page'];
    if ($page == 'post') {
        $url = 'Location: /user/post.php?post=';
    } else {
        $url = 'Location: /index.php#';
    }
    
    if ($action == 'like') {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        insertLike($user_id, $post_id);
        header($url.$post_id);
        exit();
    }

    if ($action == 'unlike') {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];

        deleteLike($user_id, $post_id);
        header($url.$post_id);
        exit();
    }

    if ($action == 'comment') {
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $content = $_POST['content'];

        insertComment($user_id, $post_id, $content);
        header($url.$post_id);
        exit();
    }
}