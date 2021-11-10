<?php require_once 'init.php'; ?>

<?php
if (isset($_POST['form_add_friend'])) {
    $user_id = $_POST['userCur'];
    $friend_id = $_POST['userFriend'];
    addFriend($user_id, $friend_id);
    header('Location: ./wall?id='.$friend_id);
}