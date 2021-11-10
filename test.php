<?php
require_once 'init.php';

try {
    global $db;
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    $u = getUserById('1');
    var_dump($u);
} catch(PDOException $e) {    
    echo "Connection failed: " . $e->getMessage();
}
?>