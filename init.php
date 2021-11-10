<?php
require_once 'functions.php';

session_start();

$db = new PDO("mysql:host=localhost;dbname=noir_lee_final", "root", "");