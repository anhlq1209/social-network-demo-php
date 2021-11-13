<?php
$r = $_SERVER['DOCUMENT_ROOT'];

require_once $r.'/config/functions.php';

session_start();

$db = new PDO("mysql:host=localhost;dbname=noir_lee", "root", "");