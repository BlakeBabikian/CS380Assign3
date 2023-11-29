<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<?php
$con = null;
require '../model/database.php';

$customer = [];
$successMessage = "";

    foreach ($_POST as $id => $value) {
        if ($value == "Select") {
            $query = "SELECT * FROM customers WHERE customerID = '$id';";
            $result = mysqli_query($con, $query);
            $customer = mysqli_fetch_array($result, MYSQLI_ASSOC);

        } elseif ($value == "Update Customer") {
            // Get the customer information from the form
            $id = $_POST['customerID'];
            $newFirstName = $_POST['first_name'];
            $newLastName = $_POST['last_name'];
            $newAddress = $_POST['address'];
            $newCity = $_POST['city'];
            $newState = $_POST['state'];
            $newPostalCode = $_POST['postal_code'];
            $newCountryCode = $_POST['country_code'];
            $newPhone = $_POST['phone'];
            $newEmail = $_POST['email'];
            $newPassword = $_POST['password'];
            $query = "UPDATE customers SET 
                firstName = '$newFirstName', 
                lastName = '$newLastName', 
                address = '$newAddress', 
                city = '$newCity', 
                state = '$newState', 
                postalCode = '$newPostalCode', 
                countryCode = '$newCountryCode', 
                phone = '$newPhone', 
                email = '$newEmail', 
                password = '$newPassword' 
                WHERE customerID = '$id';";
            $result = mysqli_query($con, $query);

            // Check if the update was successful
            if (mysqli_affected_rows($con) > 0) {
                $successMessage = "Customer information updated successfully.";
            } else {
                $successMessage = "Error updating customer information: " . mysqli_error($con);
            }
            echo "<p>$successMessage</p>";
            $query = "SELECT * FROM customers WHERE customerID = '$id';";
            $result = mysqli_query($con, $query);
            $customer = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }

    }


// Fetch available country codes from the countries table
$countryQuery = "SELECT countryCode, countryName FROM countries;";
$countryResult = mysqli_query($con, $countryQuery);
$countryCodes = [];
while ($row = mysqli_fetch_array($countryResult, MYSQLI_ASSOC)) {
    $countries[$row['countryCode']] = $row['countryName'];
}
?>
<main id='aligned'>
    <h1>View/Update Customer</h1>
    <form action='editCustomer.php' method='post' id='aligned'>
        <label for='first_name'>First Name:</label>
        <input type='text' id='first_name' name='first_name' value="<?php echo $customer['firstName']?>" ><br>

        <label for='last_name'>Last Name:</label>
        <input type='text' id='last_name' name='last_name' value="<?php echo $customer['lastName']?>"><br>

        <label for='address'>Address:</label>
        <input type='text' id='address' name='address' value="<?php echo $customer['address']?>"><br>

        <label for='city'>City:</label>
        <input type='text' id='city' name='city' value="<?php echo $customer['city']?>"><br>

        <label for='state'>State:</label>
        <input type='text' id='state' name='state' value="<?php echo $customer['state']?>"><br>

        <label for='postal_code'>Postal Code:</label>
        <input type='text' id='postal_code' name='postal_code' value="<?php echo $customer['postalCode']?>"><br>

        <label for='country_code'>Country Code:</label>
        <select id='country_code' name='country_code'>
            <?php
            foreach ($countries as $code => $name) {
                echo "<option value='$code' " . ($code == $customer['countryCode'] ? 'selected' : '') . ">$name</option>";
            }
            ?>
        </select><br>
        <label for='phone'>Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $customer['phone']?>"><br>

        <label for='email'>Email:</label>
        <input type='email' id='email' name='email' value="<?php echo $customer['email']?>"><br>

        <label for='password'>Password:</label>
        <input type='text' id='password' name='password' value="<?php echo $customer['password']?>"><br>

        <input type="hidden" name="customerID" value="<?php echo $customer['customerID']?>">

        <input type='submit' name="submit" value='Update Customer' style="margin-left: 145px">
    </form>
    <a href='selectCustomer.php'>Search Customers</a>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>