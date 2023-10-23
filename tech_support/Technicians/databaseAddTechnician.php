<?php
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$errors = "";

foreach ($_POST as $key => $val) {
    if ($val == "") {
        $errors .= 'No ' . $key . ' inputted. ';
    }
}
echo $errors;
if ($errors != "") {
    $error = "<h1>No First Name Inputted</h1>";
    header("Location: ../errors/error.php?error=" . urlencode($error));
    exit; // Make sure to exit after header redirect
}
