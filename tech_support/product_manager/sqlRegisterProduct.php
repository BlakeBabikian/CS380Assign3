<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Product SQL</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<h1>Register Product:</h1>
<main id="aligned">
<?php
$con = null;
if (!empty($_POST['Register']) && !empty($_POST['product'])) { # ensure submit button has been hit, and select box option selected
    $product = $_POST['product']; # get the product code from post variables
    $customerID = $_POST['customerID']; # get the customer id from post variables
    $date = date('Y-m-d H:i:s'); # current date and time in 'YYYY-MM-DD HH:MM:SS' format

    require '../model/database.php';

    $sql = array( # array with sql statements
        "USE bbabikian;",
        "INSERT INTO registrations (customerID, productCode, registrationDate) 
         VALUES ('$customerID', 
                 '$product', 
                 '$date');");

    try{
        for ($i = 0; $i<sizeof($sql); $i++){ # for loop going through sql statements
            $query = $sql[$i]; # get sql statement
            mysqli_query($con, $query);} # execute sql statement

    } catch(Exception $e) {
        $error = $e->getMessage(); # set error message
        header("Location: ../errors/database_error.php?error_message=$error");} # redirect to error page with error message

    finally {
        echo "<p>Product (".$product.") was registered successfully</p>"; # Success message
        mysqli_close($con);} # close connection
}
?>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>
