<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Incident SQL</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<main id="aligned">
<h1>Create Incident</h1>
<?php

error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require '../errors/testInput.php';

$con = null;
if (!empty($_POST['Create']) && !empty($_POST['Title']) &&
    !empty($_POST['Description']) && !empty($_POST['product'])) {
    foreach ($_POST as $key => $value) {
        $test = test_input($value);
        if (!$test) header("Location: ../errors/error.php?error_message=$test");}
    $productCode = $_POST['product']; # get the product code from post variables
    $Title = $_POST['Title']; # get the title from post variables
    $Description = $_POST['Description']; # get the description from post variables
    $customerID = $_POST['customerID']; # get the customer id from post variables
    $date = date('Y-m-d H:i:s'); # date
    $null = NULL; # NULL
    require '../model/database.php';
    try{
        $query = mysqli_prepare($con, "INSERT INTO incidents (customerID, productCode, techID, dateOpened, 
                    dateClosed, title, description) VALUES (?,?,?,?,?,?,?);");
        mysqli_stmt_bind_param($query, "dsdssss", 
            $customerID, $productCode, $null, $date, $null, $Title, $Description);
        mysqli_stmt_execute($query);}
    catch(Exception $e) {
        $error = $e->getMessage(); # set error message
        header("Location: ../errors/database_error.php?error_message=$error");} # redirect to error page with error message

    finally {
        echo "<p>This incident was added to our database.</p>"; # Success message
        mysqli_close($con);} # close connection
}
else header("Location: createIncident.php");
?>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>
