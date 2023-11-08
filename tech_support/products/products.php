<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?php include '../view/header.php'; ?>

<?php
$con = null;
require '../model/database.php';

if (! empty($_POST)) {
    foreach ($_POST as $id => $value) {
        if ($value == "Delete") {
            $query = "DELETE FROM products WHERE productCode='$id';";
            $result = mysqli_query($con, $query);}
    }
}

$query = "SELECT * FROM products;"; // Set the variable Query
$result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con)); // Run the query
echo "<main id='aligned'>";
echo "<table id='aligned'>";
echo "<thead>";
echo "<tr>";
while ($line = mysqli_fetch_field($result)) {
    echo "<th>$line->name</th>";
}

echo "</tr>";
echo "</thead>";
echo "<tbody>";
echo "<form id='deleteProd' action='products.php' method='post'>";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<tr>"; // Open html table row
    foreach ($line as $field_name => $field_value) { // Go through data in sql row
        echo "<td>$field_value</td>"; // Print data to table data tag
    }
    echo "<td>
              <input type='submit' name='{$line['productCode']}' value='Delete'>
          </td>";
    echo "</tr>"; // Close html table row
}
echo "</form>";

echo "</tbody>";
echo "</table>";
echo "<a href='addProduct.php'>Add Product</a>";
echo "</main>";
?>
<?php include '../view/footer.php'; ?>
</body>
</html>
