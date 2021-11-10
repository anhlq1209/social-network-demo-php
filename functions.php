<?php

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
    $stmt = $db->prepare("SELECT * FROM posts WHERE user_id=? ORDER BY createAt DESC");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function getPostAll() {
    global $db;
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY createAt DESC");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}