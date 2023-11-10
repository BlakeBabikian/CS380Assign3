<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Product</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<?php include '../view/header.php'; ?>
<body>
<h1 style='margin-left: 20px'>Register Product</h1>
<main id="aligned"
<?php
$con = null;
require '../model/database.php';
$email = $_POST['email']; # set email to email in post variables

if (! empty($email)) { # ensure that a email has been entered
    $query = "SELECT * FROM customers WHERE email = '$email'"; # query
    $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); # run query
    $line = mysqli_fetch_array($result, MYSQLI_ASSOC); # get array based of query
    if (! empty($line)) { # ensure the query returned a valid customer
        $first_name = $line['firstName']; # save customer first name for display
        $last_name = $line['lastName']; # save customer last name for display
        $id = $line['customerID']; # save customer ID for later data entry
        echo "<label for='customer'>Customer:</label>";
        echo "<span id='customer' style='margin-left: 72px;'>$first_name $last_name</span><br><br>"; # format customer name
        echo "<form action='sqlRegisterProduct.php' method='post' id='aligned'>"; # Product registration form
        echo "<input type='hidden' name='customerID' value='$id'>"; # pass customer ID
        echo "<label for='product' id='aligned'>Product:</label>";
        echo "<select name='product' id='product'>"; # select box of products in database

        $query = "SELECT * FROM products ORDER BY name;"; # query

        $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); # run query

        $rows = mysqli_num_rows($result); # count records
        
        if ($rows < 1) { # ensure that the query has returned a workable value
            $error = "Error Loading database"; # set message
            header("Location: ../errors/database_error.php?error_message=$error");} # redirect to error page with error message
        
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { # go through sql table rows
            echo '<option value=' . $line ['productCode'] . '>' . $line ['name'] . ' </option>';} # add option to select box

        echo "</select><br><br>"; # close out select box
        echo "<input type='submit' name='Register' style='margin-left: 145px;'><br><br></form>"; # submit and end product registration form
        mysqli_close($con); # close connection
    }
    else{ # if the query did not return anything
        $error = 'Did not recognize customer info.'; # message
        header("Location: ../errors/error.php?error=$error");} # redirect to error page with error message
}
?>
</body>
</body>
<?php include '../view/footer.php'; ?>
</html>
