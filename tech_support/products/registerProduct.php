<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Technician</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<?php include '../view/header.php'; ?>
<body>
<?php
$con = null;
require '../model/database.php';
$email = $_POST['email'];
echo "<h1>Register Product:</h1>";
if (! empty($email)) {
    $query = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con));
    $line = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (! empty($line)) {
        $first_name = $line['firstName'];
        $last_name = $line['lastName'];
        $id = $line['customerID'];
        echo "<label for='customer'>Customer:</label>";
        echo "<span id='customer' style='margin-left: 72px;'>$first_name $last_name</span><br><br>";
        echo "<form action='sqlRegisterProduct.php' method='post' id='aligned'>";
        echo "<input type='hidden' name='customerID' value='$id'>";
        echo "<label for='product' id='aligned'>Product:</label>";
        echo "<select name='product' id='product'>";

        $query = "SELECT * FROM products ORDER BY name;";

        $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con));

        $rows = mysqli_num_rows($result);   //how many records in result set
        
        if ($rows < 1)
            header("Location: error.php");
        
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<option value=' . $line ['productCode'] . '>' . $line ['name'] . ' </option>';
        }
        echo "</select><br><br>";
        echo "<input type='submit' name='Register' style='margin-left: 145px;'><br><br></form>";
        mysqli_close($con);
    }
    else{
        echo '<h4>'.'Did not recognize login info'.'</h4>';}
}
?>

</body>
<?php include '../view/footer.php'; ?>
</html>
