<?php
$host = 'webdev.bentley.edu';
$db = 'bbabikian';
$user = 'bbabikian';
$password = '3726';

//connection string
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

//connect to DB
try {
    //create PDO object
    $pdo = new PDO($dsn, $user, $password);

} catch (PDOException $e) {
    echo $e->getMessage(); exit();
}