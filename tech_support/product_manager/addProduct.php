<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?php include '../view/header.php'; ?>
<?php # header("Location: error.php?code=$code&message=$message");
require '../errors/testInput.php';
$product_data = []; # set array
$con = null;
foreach ($_POST as $key => $value) { # key = input name # value = input value
    if ($value === "") { # if no value assigned, enter
        echo "<p style='color: red;' id='aligned'>".'No '.$key.' inputted'."</p>";
    }
    else {
        $test = test_input($value); # this function will return true if the input is valid
        if ($test === true) {
            $product_data[] = $value;
        }
        else {
            header("Location: ../errors/error.php?error=$test");
        }
    }
}
if (sizeof($product_data) == 5) { # this is to prevent the sql from running if there is an empty field
    require '../model/database.php';
    $sql = array(
        "USE bbabikian;", # Change to user-name!
        "INSERT INTO products (productCode, name, version, releaseDate) 
             VALUES ('$product_data[0]', 
                     '$product_data[1]', 
                     '$product_data[2]', 
                     '$product_data[3]');");


    try{
        for ($i = 0; $i<sizeof($sql); $i++){
            $query = $sql[$i];
            mysqli_query($con, $query);
        }
        header("Location: product.php");
    } catch(Exception $e) {
        $error = "Error: ".$e->getMessage();
        header("Location: ../errors/error.php?error=$error");}
    finally {
        mysqli_close($con);
        exit();
    }
}

?>
<main id='aligned'>
    <h1>Add Product</h1>
    <form action='addProduct.php' method='post' id='aligned'>
        <label for='code'>Code:</label>
        <input type='text' id='code' name='code'><br><br>

        <label for='name'>Name:</label>
        <input type='text' id='name' name='name'><br><br>

        <label for='version'>Version:</label>
        <input type='text' id='version' name='version'><br><br>

        <label for='release_date'>Release Date:</label>
        <input type="text" id="rel_date" name="rel_date" maxlength="10" pattern="^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$" title="Use 'yyyy-mm-dd' format"><br><br>

        <input type='submit' value='Add Product' style="margin-left: 145px">
    </form>
</main>
<nav>
    <ul>
        <li><a href="products.php">View Products List</a></li>
    </ul>
</nav>
<?php include '../view/footer.php'; ?>
</body>
</html>
