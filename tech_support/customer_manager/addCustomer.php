<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Customer</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
    <style>
        .required-text {
            color: red;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<?php include '../view/header.php';
$con = null;
require '../model/database.php';

// Fetch available country codes from the countries table
$countryQuery = "SELECT countryCode, countryName FROM countries;";
$countryResult = mysqli_query($con, $countryQuery);
$countryCodes = [];
while ($row = mysqli_fetch_array($countryResult, MYSQLI_ASSOC)) {
    $countries[$row['countryCode']] = $row['countryName'];
}
?>

<main id='aligned'>
    <h1>Add Customer</h1>
    <form action='addCustomer.php' method='post' id='aligned' onsubmit="return validateForm()">
        <label for='first_name'>First Name:</label>
        <span id="firstRequired" class="required-text"></span>
        <input type='text' id='first_name' name='first_name' min="1" max="51"><br>

        <label for='last_name'>Last Name:</label>
        <span id="lastRequired" class="required-text"></span>
        <input type='text' id='last_name' name='last_name' min="1" max="51""><br>

        <label for='address'>Address:</label>
        <span id="addressRequired" class="required-text"></span>
        <input type='text' id='address' name='address' min="1" max="51"><br>

        <label for='city'>City:</label>
        <span id="cityRequired" class="required-text"></span>
        <input type='text' id='city' name='city' min="1" max="51"><br>

        <label for='state'>State:</label>
        <span id="stateRequired" class="required-text"></span>
        <input type='text' id='state' name='state' min="2" max="2"><br>

        <label for='postal_code'>Postal Code:</label>
        <span id="postalRequired" class="required-text"></span>
        <input type='text' id='postal_code' name='postal_code' min="1" max="15"><br>

        <label for='country_code'>Country Code:</label>
        <select id='country_code' name='country_code'>
            <?php
            foreach ($countries as $code => $name) {
                echo "<option value='$code'>$name</option>";
            }
            ?>
        </select><br>
        <label for='phone'>Phone:</label>
        <span id="phoneRequired" class="required-text"></span>
        <input type="tel" id="phone" name="phone" pattern="[\(\d{3}\) \d{3}-\d{4}]"><br>

        <label for='email'>Email:</label>
        <span id="emailRequired" class="required-text"></span>
        <input type='email' id='email' name='email' min="1" max="51"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"><br>

        <label for='password'>Password:</label>
        <span id="passwordRequired" class="required-text"></span>
        <input type='text' id='password' name='password' min="6" max="21"><br>

        <input type='submit' name="submit" value='Add Customer' style="margin-left: 145px">
    </form>

    <script>
        function validateForm() {
            let firstValue = document.getElementById('first_name').value;
            let lastValue = document.getElementById('last_name').value;
            let addressValue = document.getElementById('address').value;
            let cityValue = document.getElementById('city').value;
            let stateValue = document.getElementById('state').value;
            let postalValue = document.getElementById('postal_code').value;
            let phoneValue = document.getElementById('phone').value;
            let emailValue = document.getElementById('email').value;
            let passwordValue = document.getElementById('password').value;

            let phonePattern = /\(\d{3}\) \d{3}-\d{4}/;
            let emailPattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/;

            // Reset previous error messages
            document.getElementById('firstRequired').innerHTML = '';
            document.getElementById('lastRequired').innerHTML = '';
            document.getElementById('addressRequired').innerHTML = '';
            document.getElementById('cityRequired').innerHTML = '';
            document.getElementById('stateRequired').innerHTML = '';
            document.getElementById('postalRequired').innerHTML = '';
            document.getElementById('emailRequired').innerHTML = '';
            document.getElementById('phoneRequired').innerHTML = '';
            document.getElementById('passwordRequired').innerHTML = '';

            // Check if values are empty
            if (firstValue === '') {
                document.getElementById('firstRequired').innerHTML = 'Required';
                return false
            }
            if (lastValue === '') {
                document.getElementById('lastRequired').innerHTML = 'Required';
                return false
            }
            if (addressValue === '') {
                document.getElementById('addressRequired').innerHTML = 'Required';
                return false
            }
            if (cityValue === '') {
                document.getElementById('cityRequired').innerHTML = 'Required';
                return false
            }
            if (stateValue === '') {
                document.getElementById('stateRequired').innerHTML = 'Required';
                return false
            }
            if (stateValue.length < 2 || stateValue.length > 2){
                document.getElementById('stateRequired').innerHTML = 'Enter a two character state code'
                return false
            }
            if (postalValue === '') {
                document.getElementById('postalRequired').innerHTML = 'Required';
                return false
            }
            if (!phonePattern.test(phoneValue)) {
                document.getElementById('phoneRequired').innerHTML = 'Use (999) 999-9999 format';
                return false
            }
            if (!emailPattern.test(emailValue)) {
                document.getElementById('emailRequired').innerHTML = 'Invalid email format';
                return false
            }
            if (passwordValue.length < 6) {
                document.getElementById('passwordRequired').innerHTML = 'Password is too short'
                return false
            }
            if (passwordValue.length > 21) {
                document.getElementById('passwordRequired').innerHTML = 'Password is too long'
                return false
            }
            return true;
        }
    </script>
    <a href='selectCustomer.php'>Search Customers</a>
</main>
<?php include '../view/footer.php'; ?>
<?php

require '../errors/testInput.php';
$customer_data = []; # set array
$successMessage = "";
$con = null;

foreach ($_POST as $key => $value) { # key = input name # value = input value
    if ($value === "") echo "<p style='color: red;' id='aligned'>".'No '.$key.' inputted'."</p>";
    else {
        $test = test_input($value); # this function will return true if the input is valid
        if ($test === true) $customer_data[] = $value;
        else header("Location: ../errors/error.php?error=$test");
    }
}

error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (sizeof($customer_data) == 11) { # this is to prevent the sql from running if there is an empty field
    require '../model/database.php';
    try {
        $query = mysqli_prepare($con, "INSERT INTO customers 
            (firstName, lastName, address, city, state, postalCode, countryCode, phone, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($query, "ssssssssss", $customer_data[0], $customer_data[1], $customer_data[2], $customer_data[3], $customer_data[4],
            $customer_data[5], $customer_data[6], $customer_data[7], $customer_data[8], $customer_data[9]);
        mysqli_stmt_execute($query);
        header("Location: selectCustomer.php");
        $successMessage = "Customer information added successfully.";
        echo "<p>$successMessage</p>";
    }
    catch(Exception $e) {
        $error = "Error: ".$e->getMessage();
        header("Location: ../errors/database_error.php?error_message=$error");
        $successMessage = "Error updating customer information: " . mysqli_error($con);
        echo "<p>$successMessage</p>";
    }
    finally {
        mysqli_close($con);
        exit();
    }
}
?>
</body>
</html>
