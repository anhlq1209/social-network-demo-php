<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$r = $_SERVER['DOCUMENT_ROOT'];

require $r.'/vendor/autoload.php';

function showAlertDanger($content) { ?>
    <div class="alert alert-danger mt-3" role="alert">
        <?php echo $content ?>
    </div>
<?php }

function showAlertWarning($content) { ?>
    <div class="alert alert-warning mt-3" role="alert">
        <?php echo $content ?>
    </div>
<?php }

function showAlertSuccess($content) { ?>
    <div class="alert alert-success mt-3" role="alert">
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
    $stmt = $db->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->execute(array($id));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rows;
}

function getPostByUserId($id) {
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

function getFriendsById($id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM friends WHERE user_id=?");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function insertFriend($user_id, $friend_id) {
    global $db;
    $sql = "call sp_InsertFriend(". $user_id . ", " . $friend_id . ")";
    $stmt= $db->prepare($sql);
    $stmt->execute();
}

function deleteFriend($user_id, $friend_id) {
    global $db;
    $sql = "call sp_DeleteFriend(". $user_id . ", " . $friend_id . ")";
    $stmt= $db->prepare($sql);
    $stmt->execute();
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

function checkRequestFriendToMe($user_id, $friend_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM friend_requests WHERE user_id=? and friend_id=?");
    $stmt->execute(array($friend_id, $user_id));
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
    $query = $db->prepare("DELETE FROM friend_requests WHERE (user_id=? and friend_id=?) or (user_id=? and friend_id=?)");
    $query->execute(array($user_id, $friend_id, $friend_id, $user_id));
}

function getFriendRequest($id) {
    global $db;
    $query = $db->prepare("SELECT * FROM friend_requests WHERE friend_id=?");
    $query->execute(array($id));
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function insertUser($name, $mail, $phone, $pass) {
    global $db;
    $hashPassword = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users(displayname, email, password, phone) VALUES(?, ?, ?, ?)";
    $stmt= $db->prepare($sql);
    $stmt->execute([$name, $mail, $hashPassword, $phone]);
}

function updateCode($code, $email) {
    global $db;
    $query = $db->prepare("UPDATE users SET code=? WHERE email=?");
    $query->execute(array($code, $email));
}

function sendForgotPasswordEmail($email) {
    $code = uniqid();
    updateCode($code, $email);

    $mail = new PHPMailer(true);

    // $mail->SMTPDebug  = 1;
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->isSMTP();   
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "noirlee.1208@gmail.com";
    $mail->Password   = "Noirlee1208@";

    $mail->setFrom('noirlee.1208@gmail.com', 'Noir Lee');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Qu??n m???t kh???u trang web Noir Lee';
    $mail->Body    = 'M???i b???n ???n v??o ?????a ch??? d?????i ????y ????? kh??i ph???c m???t kh???u:<br/>http://noirlee/change-password.php?code=' . $code;
    $mail->AltBody = 'Email qu??n m???t kh???u trang web Noir Lee';

    $mail->send();
}

function checkCode($code) {
    global $db;
    $query = $db->prepare("SELECT * FROM users WHERE code=?");
    $query->execute(array($code));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row)
        return true;
    return false;
}

function updatePasswordByCode($code, $pass) {
    global $db;
    $hashPassword = password_hash($pass, PASSWORD_DEFAULT);

    $query1 = $db->prepare("UPDATE users SET password=? WHERE code=?");
    $query1->execute(array($hashPassword, $code));

    $query2 = $db->prepare("UPDATE users SET code=? WHERE code=?");
    $query2->execute(array(null, $code));
}

function getImagesByPost($id) {
    global $db;
    $query = $db->prepare("SELECT * FROM images_post WHERE post_id=?");
    $query->execute(array($id));
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function isUserLikePost($user_id, $post_id) {
    global $db;
    $query = $db->prepare("SELECT * FROM likes WHERE user_id=? and post_id=?");
    $query->execute(array($user_id, $post_id));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row)
        return true;
    return false;
}

function insertLike($user_id, $post_id) {
    global $db;
    $stmt= $db->prepare("INSERT INTO likes(user_id, post_id) VALUES(?, ?)");
    $stmt->execute(array($user_id, $post_id));
}

function deleteLike($user_id, $post_id) {
    global $db;
    $stmt= $db->prepare("DELETE FROM likes WHERE user_id=? and post_id=?");
    $stmt->execute(array($user_id, $post_id));
}

function insertComment($user_id, $post_id, $content) {
    global $db;
    $stmt= $db->prepare("INSERT INTO comments(user_id, post_id, content) VALUES(?, ?, ?)");
    $stmt->execute(array($user_id, $post_id, $content));
}

function getCommentByPost($id) {
    global $db;
    $query = $db->prepare("SELECT * FROM comments WHERE post_id=?");
    $query->execute(array($id));
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}