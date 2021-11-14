<?php

require_once '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page = $_POST['page'];
    $user_id = $_POST['user_id'];
    $friend_id = $_POST['friend_id'];
    if ($page == 'wall') {
        $url = 'Location: /user/wall.php?id='.$friend_id;
    } else {
        $url = 'Location: /friend/friend-req.php';
    }

    if ($_POST['handle_name'] == "add_friend") {
        insertFriendRequest($user_id, $friend_id);
        header($url);
        exit();
    } else
    
    if ($_POST['handle_name'] == "unfriend") {
        deleteFriend($user_id, $friend_id);
        header($url);
        exit();
    } else
    
    if ($_POST['handle_name'] == "cancel_friend_request") {
        deleteFriendRequest($user_id, $friend_id);
        header($url);
        exit();
    } else
    
    if ($_POST['handle_name'] == "accept_friend_request") {
        insertFriend($user_id, $friend_id);
        deleteFriendRequest($user_id, $friend_id);
        header($url);
        exit();
    } else
    
    if ($_POST['handle_name'] == "decline_friend_request") {
        deleteFriendRequest($user_id, $friend_id);
        header($url);
        exit();
    }
} else {
    header('Location: /index.php');
    exit();
}
