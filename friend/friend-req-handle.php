<?php

require_once '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['handle_name'] == "add_friend") {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        insertFriendRequest($user_id, $friend_id);
        header('Location: /user/wall.php?id=' . $friend_id);
        exit();
    } else
    
    if ($_POST['handle_name'] == "unfriend") {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        deleteFriend($user_id, $friend_id);
        header('Location: /user/wall.php?id=' . $friend_id);
        exit();
    } else
    
    if ($_POST['handle_name'] == "cancel_friend_request") {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        deleteFriendRequest($user_id, $friend_id);
        header('Location: /user/wall.php?id=' . $friend_id);
        exit();
    } else
    
    if ($_POST['handle_name'] == "accept_friend_request") {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        insertFriend($user_id, $friend_id);
        deleteFriendRequest($user_id, $friend_id);
        header('Location: /friend/friend-req.php');
        exit();
    } else
    
    if ($_POST['handle_name'] == "decline_friend_request") {
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];
        deleteFriendRequest($user_id, $friend_id);
        header('Location: /friend/friend-req.php');
        exit();
    }
} else {
    header('Location: /index.php');
    exit();
}
