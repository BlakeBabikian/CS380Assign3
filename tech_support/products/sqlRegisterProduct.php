<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register Product</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?php include '../view/header.php'; ?>
<?php
$con = null;
echo "<h1>Register Product:</h1>";
if (!empty($_POST['Register']) && !empty($_POST['product'])) {
    $product = $_POST['product'];
    $customerID = $_POST['customerID'];
    $date = date('Y-m-d H:i:s'); // Output: Current date and time in 'YYYY-MM-DD HH:MM:SS' format

    require '../model/database.php';
    $sql = array(
        "USE bbabikian;",
        "INSERT INTO registrations (customerID, productCode, registrationDate) 
             VALUES ('$customerID', 
                     '$product', 
                     '$date');");

    try{
        for ($i = 0; $i<sizeof($sql); $i++){
            $query = $sql[$i];
            mysqli_query($con, $query);
        }
    } catch(Exception $e) {
        $error = "Error: ".$e->getMessage();
        header("Location: ../errors/error.php?error=$error");}
    finally {
        echo "<p>Product (".$product.") was registered successfully</p>";
        mysqli_close($con);
    }
}
?>
<?php include '../view/footer.php'; ?>
</body>
</html>
