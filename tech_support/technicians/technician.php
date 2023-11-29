<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Technicians</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<h1 style="margin-left: 20px">Manage Technicians</h1>
<?php
$con = null;
require '../model/database.php';

if (! empty($_POST)) { # checking that the post variables are not empty
    foreach ($_POST as $id => $value) { # go through post variables looking for techID=>Delete
        if ($value == "Delete") { # if tech was selected to be deleted
            $query = mysqli_prepare($con, "DELETE FROM technicians WHERE techID=?;");
            mysqli_stmt_bind_param($query, "s", $id);
            mysqli_stmt_execute($query);} # run query
    }
}

$query = "SELECT * FROM technicians;"; // Set the variable Query
$result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); // Run the query
echo "<main id='aligned'>";

echo "<table id='aligned'>";

echo "<thead>";
echo "<tr>";
while ($line = mysqli_fetch_field($result)) { # while loop going through sql column names
    echo "<th>$line->name</th>";} #
echo "</tr>";
echo "</thead>";

echo "<tbody>";
echo "<form id='deleteTech' action='technician.php' method='post'>"; # set up form, with delete buttons at end of each html table row
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { # go through sql table row by row
    echo "<tr>"; # open table row
        foreach ($line as $field_name => $field_value) { # for loop going through table row, value by value
            echo "<td>$field_value</td>";} # add all
            echo "<td><input type='submit' name='{$line['techID']}' value='Delete'></td>"; # add delete button, store in post as ID=>Delete
    echo "</tr>";} # close table row

echo "</form>";
echo "</tbody>";

echo "</table>";

echo "<a href='addTechnician.php'>Add Technician</a>"; # link to add technician page

echo "</main>";
?>
<?php include '../view/footer.php'; ?>
</body>
</html>

