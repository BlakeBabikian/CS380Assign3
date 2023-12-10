<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<?php
error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$con = null;
$username = null;
require '../model/database.php';
require '../errors/testInput.php';
session_start();
if (isset($_SESSION["ValidAdmin"])) header("Location: ../homePages/adminHome.php");

elseif (! empty($_POST['Login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $test1 = test_input($username);
    $test2 = test_input($password);
    if ($test1 === true && $test2 === true) {
        try {
            $query = mysqli_prepare($con, "SELECT * FROM administrators WHERE username=? AND password=?");
            mysqli_stmt_bind_param($query, "ss", $username, $password);
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            $line = mysqli_fetch_array($result, MYSQLI_ASSOC); # get array based of query
            if (!empty($line['username'])) {
                $username = $_SESSION['username'] = $line['username']; # save customer first name for display
                $password = $_SESSION['password'] = $line['password']; # save customer last name for display
                $_SESSION['ValidAdmin'] = true;
                header("Location: ../homePages/adminHome.php");}
        }
        catch (Exception $e) {
            $error = 'Did not recognize customer email.'.$e; # message
            header("Location: ../errors/database_error.php?error_message=$error");}
    }
    else header("Location: ../errors/error.php?error=$test1");
}
?>
<main id="aligned">
    <h1>Admin Login</h1>
    <form action="adminLogin.php" method="post">
        <label for="username">Username: </label>
        <input type="text" id='username' name='username'><br>
        <label for="password">Password: </label>
        <input type="password" id='password' name='password'><br>
        <input type="submit" id="login" name="Login" style="margin-left: 145px"><br>
    </form>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>

