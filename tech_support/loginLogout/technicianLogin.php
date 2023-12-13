<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Technician Login</title>
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
$email = null;
require '../model/database.php';
require '../errors/testInput.php';
session_start();
if (isset($_SESSION["ValidTech"])) header("Location: ../homePages/techHome.php");

elseif (! empty($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $test1 = test_input($email);
    $test2 = test_input($password);
    if ($test1 === true && $test2 === true) {
        try {
            $query = mysqli_prepare($con, "SELECT * FROM technicians WHERE email=? AND password=?");
            mysqli_stmt_bind_param($query, "ss", $email, $password);
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            $line = mysqli_fetch_array($result, MYSQLI_ASSOC); # get array based of query
            if (!empty($line['firstName'])) {
                $first_name = $_SESSION['firstName'] = $line['firstName']; # save customer first name for display
                $last_name = $_SESSION['lastName'] = $line['lastName']; # save customer last name for display
                $id = $_SESSION['techID'] = $line['techID']; # save customer ID for later data entry
                $_SESSION['Email'] = $email;
                $_SESSION['ValidTech'] = true;
                header("Location: ../homePages/techHome.php");}
        }
        catch (Exception $e) {
            $error = 'Did not recognize customer email.'.$e; 
            header("Location: ../errors/database_error.php?error_message=$error");}
    }
    else header("Location: ../errors/error.php?error=$test1");
}
?>
<main id="aligned">
    <h1>Technician Login</h1>
    <form action="technicianLogin.php" method="post">
        <label for="email">Email: </label>
        <input type="text" id='email' name='email'><br>
        <label for="password">Password: </label>
        <input type="password" id='password' name='password'><br>
        <input type="submit" id="Login" name="Login" style="margin-left: 145px"><br>
    </form>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>


