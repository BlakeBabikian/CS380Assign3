<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Technicians</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?php include '../view/header.php'; ?>

<?php

require '../model/database.php';

$query = "SELECT * FROM technicians;"; // Set the variable Query
$result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); // Run the query
echo "<main id='aligned'>";
echo "<table id='aligned'>";
echo "<thead>";
echo "<tr>";
while ($line = mysqli_fetch_field($result)) {
    echo "<th>{$line->name}</th>";
}

echo "</tr>";
echo "</thead>";
echo "<tbody>";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { // While loop to go through SQl table rows
    $count = 0; // Variable to know where in loop
    echo "<tr>"; // Open html table row
    foreach ($line as $field_value) { // Go through data in sql row
            echo "<td>$field_value</td>"; // Print data to table data tag
    } // Close for each loop
    echo "<td>
              <form id='deleteTech' action='removeTechnician.php' method='post'>
                    <input type='submit' name='$line[0]' value='Delete'>
              </form>
          </td>";
    echo "</tr>"; // Close html table row
} // Close while
echo "</tbody>";
echo "</table>";
echo "<a href='addTechnician.php'>Add Technician</a>";
echo "</main>";
?>
<?php include '../view/footer.php'; ?>
</body>
</html>

