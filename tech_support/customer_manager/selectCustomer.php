<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Customers</title>
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
require '../model/database.php';
echo "<main id='aligned'>";
echo "<h1>Add a New Customer</h1>";
echo "<a href='addCustomer.php'>
        <button>Add Customer</button> 
      </a><br><br>";
echo "<h1>Customer Search</h1>";
echo "<form method='POST' action='selectCustomer.php'>";
echo "<label for='search'>Last Name: </label>";
echo "<input id='search' name='search' type='text' placeholder='Type here'>";
echo "<input id='submit' type='submit' value='Search'>";
echo "<br><h2>Results</h2>";
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    try{
        $query = mysqli_prepare($con, "SELECT customerID, CONCAT(firstname, ' ', lastname) AS 'Name', email AS 'Email Address', city AS 'City' FROM customers WHERE lastname = ?;"); // Set the variable Query
        mysqli_stmt_bind_param($query, "s", $search);
        mysqli_stmt_execute($query); # run query
        $result = mysqli_stmt_get_result($query);
    } catch (Exception $e) {
        $error = "Error: ".$e->getMessage(); # set message
        header("Location: ../errors/database_error.php?error_message=$error");}

} else {
    try{
        // If the search input is empty, retrieve all records
        $query = "SELECT customerID, CONCAT(firstname, ' ', lastname) AS 'Name', email AS 'Email Address', city AS 'City' FROM customers;";
        $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); // Run the query
    } catch (Exception $e) {
        $error = "Error: ".$e->getMessage(); # set message
        header("Location: ../errors/database_error.php?error_message=$error");}
}

echo "<table id='aligned'>";
echo "<thead>";
echo "<tr>";
while ($line = mysqli_fetch_field($result)) {
    if ($line->name !== 'customerID'){
        echo "<th>{$line->name}</th>";
    }
}

echo "</tr>";
echo "</thead>";
echo "</form>";

echo "<tbody>";
echo "<form id='viewCustomer' action='editCustomer.php' method='post'>";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<tr>"; // Open html table row
    foreach ($line as $field_name => $field_value) { // Go through data in sql row
        if ($field_name !== 'customerID') {
            echo "<td>$field_value</td>"; // Print data to table data tag
        }
    }
    echo "<td>
                  <input type='submit' name='{$line['customerID']}' value='Select'>
              </td>";
    echo "</tr>"; // Close html table row
}
echo "</form>";

echo "</tbody>";
echo "</table>";
echo "</main>";
?>
<?php include '../view/footer.php'; ?>
</body>
</html>