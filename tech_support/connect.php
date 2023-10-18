<?php
global $con;
// Connect to MySQL, select database
$con = mysqli_connect("webdev.bentley.edu","bbabikian","3726","bbabikian");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br>";
    exit("Connect Error");
}

?>