<?php
$host = 'webdev.bentley.edu';
$db = 'jbautista';
$user = 'jbautista';
$password = '6495';

//connection string
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

//connect to DB
try {
    //create PDO object
    $pdo = new PDO($dsn, $user, $password);

    if ($pdo) {
        echo "Connected to the $db database successfully!" . "\n";
    }

} catch (PDOException $e) {
    echo $e->getMessage(); exit();
}

