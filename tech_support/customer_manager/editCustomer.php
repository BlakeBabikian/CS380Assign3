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
    <style>
        .required-text {
            color: red;
            margin-left: 5px;
        }
    </style>
</head>
<body>
<?php include '../view/header.php'; ?>
<?php
$con = null;
require '../model/database.php';
require '../errors/testInput.php';


$customer = [];
$successMessage = "";

    foreach ($_POST as $id => $value) {
        if ($value == "Select") {
            try{
                $query = mysqli_prepare($con, "SELECT * FROM customers WHERE customerID = ?;");
                mysqli_stmt_bind_param($query, "s", $id);
                mysqli_stmt_execute($query); # run query
                $result = mysqli_stmt_get_result($query);
                $customer = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } catch (Exception $e) {
                $error = "Error: ".$e->getMessage(); # set message
                header("Location: ../errors/database_error.php?error_message=$error");}

        } elseif ($value == "Update Customer") {
            $test = test_input($value); # this function will return true if the input is valid
            if ($test === true) { # enter if no html injection
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
            }
            else header("Location: ../errors/error.php?error=$test"); # redirect to error page with error message
                try {
                $query = mysqli_prepare($con,"UPDATE customers SET 
                    firstName = ?, 
                    lastName = ?, 
                    address = ?, 
                    city = ?, 
                    state = ?, 
                    postalCode = ?, 
                    countryCode = ?, 
                    phone = ?, 
                    email = ?, 
                    password = ? 
                    WHERE customerID = ?;");
                mysqli_stmt_bind_param($query, "sssssssssss",
                    $newFirstName, $newLastName, $newAddress, $newCity, $newState, $newPostalCode, $newCountryCode, $newPhone, $newEmail, $newPassword, $id);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);
            } catch (Exception $e) {
                $error = "Error: ".$e->getMessage(); # set message
                header("Location: ../errors/database_error.php?error_message=$error");}

            // Check if the update was successful
            if (mysqli_affected_rows($con) > 0) {
                $successMessage = "Customer information updated successfully.";
            } else {
                $successMessage = "Error updating customer information: " . mysqli_error($con);
            }
            echo "<p>$successMessage</p>";
            try{
                $query = mysqli_prepare($con,"SELECT * FROM customers WHERE customerID = ?;");
                mysqli_stmt_bind_param($query, "s", $id);
                mysqli_stmt_execute($query); # run query
                $result = mysqli_stmt_get_result($query);
                $customer = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } catch (Exception $e) {
                $error = "Error: ".$e->getMessage(); # set message
                header("Location: ../errors/database_error.php?error_message=$error");}
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
    <form action='editCustomer.php' method='post' id='aligned' onsubmit="return validateForm()">
        <label for='first_name'>First Name:</label>
        <span id="firstRequired" class="required-text"></span>
        <input type='text' id='first_name' name='first_name' min="1" max="51"  value="<?php echo $customer['firstName']?>" ><br>

        <label for='last_name'>Last Name:</label>
        <span id="lastRequired" class="required-text"></span>
        <input type='text' id='last_name' name='last_name' min="1" max="51" value="<?php echo $customer['lastName']?>"><br>

        <label for='address'>Address:</label>
        <span id="addressRequired" class="required-text"></span>
        <input type='text' id='address' name='address' min="1" max="51" value="<?php echo $customer['address']?>"><br>

        <label for='city'>City:</label>
        <span id="cityRequired" class="required-text"></span>
        <input type='text' id='city' name='city' min="1" max="51" value="<?php echo $customer['city']?>"><br>

        <label for='state'>State:</label>
        <span id="stateRequired" class="required-text"></span>
        <input type='text' id='state' name='state' min="2" max="2" value="<?php echo $customer['state']?>"><br>

        <label for='postal_code'>Postal Code:</label>
        <span id="postalRequired" class="required-text"></span>
        <input type='text' id='postal_code' name='postal_code' min="1" max="15" value="<?php echo $customer['postalCode']?>"><br>

        <label for='country_code'>Country Code:</label>
        <select id='country_code' name='country_code'>
            <?php
            foreach ($countries as $code => $name) {
                echo "<option value='$code' " . ($code == $customer['countryCode'] ? 'selected' : '') . ">$name</option>";
            }
            ?>
        </select><br>
        <label for='phone'>Phone:</label>
        <span id="phoneRequired" class="required-text"></span>
        <input type="tel" id="phone" name="phone" pattern="\(\d{3}\) \d{3}-\d{4}" value="<?php echo $customer['phone']?>"><br>

        <label for='email'>Email:</label>
        <span id="emailRequired" class="required-text"></span>
        <input type='email' id='email' name='email' min="1" max="51"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"   required value="<?php echo $customer['email']?>"><br>

        <label for='password'>Password:</label>
        <span id="passwordRequired" class="required-text"></span>
        <input type='text' id='password' name='password' min="6" max="21" value="<?php echo $customer['password']?>"><br>

        <input type="hidden" name="customerID" value="<?php echo $customer['customerID']?>">

        <input type='submit' name="submit" value='Update Customer' style="margin-left: 145px">
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
</body>
</html>