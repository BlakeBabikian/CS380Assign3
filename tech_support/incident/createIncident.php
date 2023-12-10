<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Incident</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<?php include '../view/header.php'; ?>
<body>
<main id="aligned">
<h1>Create Incident</h1>
<?php

error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$con = null;
$email = null;
if (! empty($_POST)) $email = $_POST['email']; # set email to email in post variables
require '../model/database.php';
require '../errors/testInput.php';
session_start();
if ($email != null) { # enter if coming from login form
    $test = test_input($email);
    if ($test === true) {
        try {
            $query = mysqli_prepare($con, "SELECT * FROM customers WHERE email=?");
            mysqli_stmt_bind_param($query, "s", $email);
            mysqli_stmt_execute($query);
            $result = mysqli_stmt_get_result($query);
            $line = mysqli_fetch_array($result, MYSQLI_ASSOC); # get array based of query
            if (!empty($line['firstName'])) {
                $first_name = $_SESSION['firstName'] = $line['firstName']; # save customer first name for display
                $last_name = $_SESSION['lastName'] = $line['lastName']; # save customer last name for display
                $id = $_SESSION['customerID'] = $line['customerID']; # save customer ID for later data entry
                $_SESSION['Email'] = $email;
                $_SESSION['ValidCustomer'] = true;}
            else header("Location: registerProductLogin.php");}
        catch (Exception $e) {
            $error = 'Did not recognize customer email.'.$e; # message
            header("Location: ../errors/database_error.php?error_message=$error");}
    }
    else header("Location: ../errors/error.php?error=$test");
}
    
else {
    $first_name = $_SESSION['firstName']; # save customer first name for display
    $last_name = $_SESSION['lastName']; # save customer last name for display
    $id = $_SESSION['customerID']; # save customer ID for later data entry
    $email = $_SESSION['Email'];} # save customer email for later data entry


if ($email != null) { # ensure that an email has been entered
    echo "<form action='sqlCreateIncident.php' method='post' id='aligned'>"; # Product registration form
    echo "<label for='customer' style='margin-right: 17px'>Customer:</label>";
    echo "<span id='customer'>$first_name $last_name</span><br>"; # format customer name
    echo "<input type='hidden' name='customerID' value='$id'>"; # pass customer ID
    echo "<label for='product' id='aligned'>Product:</label>";
    echo "<select name='product' id='product'>"; # select box of products in database
    $query = "SELECT registrations.productCode, products.name as product_name
              FROM registrations
              INNER JOIN products ON registrations.productCode = products.productCode
              WHERE registrations.customerID = $id;"; # query
    $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); # run query
    $rows = mysqli_num_rows($result); # count records
    if ($rows < 1) { # ensure that the query has returned a workable value
        $error = "Error Loading database"; # set message
        header("Location: ../errors/database_error.php?error_message=$error");} # redirect to error page with error message
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { # go through sql table rows
        echo '<option value=' . $line ['productCode'] . '>' . $line ['product_name'] . ' </option>';} # add option to select box
    echo "</select><br>"; # close out select box
    echo "<label for='Title' style='margin-right: 17px'>Title:</label>";
    echo "<input type='text' name='Title'><br>";
    echo "<label for='Description' style='margin-right: 17px'>Description:</label>";
    echo "<textarea name='Description' style='width: 300px; height: 50px'></textarea><br>";
    echo "<input type='submit' value='Create Incident' name='Create' style='margin-left: 145px;'></form><br>"; # submit and end product registration form
    echo "<span>"."You are signed in as ".$email."</span>";
    echo "<br><form action='../loginLogout/logout.php' method='post'><input type='submit' value='Log Out' name='LogOut'></form>";
    mysqli_close($con); # close connection
}
else header("Location: createIncidentLogin.php");
?>
</main>
</body>
<?php include '../view/footer.php'; ?>
</html>
