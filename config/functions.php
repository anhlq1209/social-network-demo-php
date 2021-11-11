<?php

function showAlertDanger($content) { ?>
    <div class="alert alert-danger mt-3" role="alert">
        <?php echo $content ?>
    </div>
<?php }

function getUserByEmail($email) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function getUserById($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function checkUser($email) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute(array($email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row)
        return true;
    return false;
}

function checkPassword($pass) {
    $user = getUserById($_SESSION['userId']);
    if (password_verify($pass, $user['password']))
        return true;
    return false;
}

function getPostById($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM posts WHERE user_id=? ORDER BY created_at DESC");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getPostAll() {
    global $db;
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY created_at DESC");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getPostForUser($id) {
    global $db;

    $f_query = $db->prepare("SELECT * FROM friends WHERE user_id=?");
    $f_query->execute(array($id));
    $friends = $f_query->fetchAll(PDO::FETCH_ASSOC);
    var_dump($friends);

    $sql = "SELECT * FROM posts WHERE user_id=?";
    foreach ($friends as $friend) {
        $sql = $sql . " or " . $friend['friend_id'] . "=?"; 
    }
    $sql = $sql . " ORDER BY created_at DESC";
    $p_query = $db->prepare($sql);
    $p_query->execute();
    $rows = $p_query->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getFriendsById($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM friends WHERE user_id=?");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function insertFriend($user_id, $friend_id) {
    global $db;
    $sql = "INSERT INTO friends(user_id, friend_id) VALUES(?, ?)";
    $stmt= $db->prepare($sql);
    $stmt->execute([$user_id, $friend_id]);
}

function checkFriend($user_id, $friend_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM friends WHERE user_id=? and friend_id=?");
    $stmt->execute(array($user_id, $friend_id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row)
        return true;
    return false;
}

function checkRequestFriend($user_id, $friend_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM friend_requests WHERE user_id=? and friend_id=?");
    $stmt->execute(array($user_id, $friend_id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row)
        return true;
    return false;
}

function insertFriendRequest($user_id, $friend_id) {
    global $db;
    $query = $db->prepare("INSERT INTO friend_requests(user_id, friend_id) VALUES(?, ?)");
    $query->execute(array($user_id, $friend_id));
}

function deleteFriendRequest($user_id, $friend_id) {
    global $db;
    $query = $db->prepare("DELETE FROM friend_requests WHERE user_id=? and friend_id=?");
    $query->execute(array($user_id, $friend_id));
}

function getFriendRequest($id) {
    global $db;
    $query = $db->prepare("SELECT * FROM friend_requests WHERE friend_id=?");
    $query->execute(array($id));
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}