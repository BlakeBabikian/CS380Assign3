<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Technician</title>
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

require '../errors/testInput.php';
$person_data = []; # set array
$con = null;
foreach ($_POST as $key => $value) { # key = input name # value = input value
    if ($value === "") { # if no value assigned, enter
        echo "<p style='color: red;' id='aligned'>".'No '.$key.' inputted'."</p>";} # display message
    else {
        $test = test_input($value); # this function will return true if the input is valid
        if ($test === true) { # enter if no html injection
            if ($key === 'phone'){ # enter if the value in post is for phone
                $new_number = ''; # set empty string
                $num = str_split($value); # split the string by digit
                $new_number = $num[0].$num[1].$num[2]."-".$num[3].$num[4].$num[5]."-".$num[6].$num[7].$num[8].$num[9];
                $person_data[] = $new_number;} # add formatted number to array
            else $person_data[] = $value;} # add data to array
        else header("Location: ../errors/error.php?error=$test"); # redirect to error page with error message
    }
}
if (sizeof($person_data) == 5) { # this is to prevent the sql from running if there is an empty field
    require '../model/database.php';
        try{
            $query = mysqli_prepare($con,
                "INSERT INTO technicians (firstName, lastName, email, phone, password) VALUES (?,?,?,?,?);");
            mysqli_stmt_bind_param($query, "sssss",
                $person_data[0],$person_data[1], $person_data[2],$person_data[3],$person_data[4]);
            mysqli_stmt_execute($query);
            header("Location: technician.php");}
        catch(Exception $e) {
            $error = "Error: ".$e->getMessage(); # set message
            header("Location: ../errors/database_error.php?error_message=$error");} # redirect to error page with error message
        finally {
            mysqli_close($con); # close connection
            exit();}
}
?>
<main id='aligned'>
<h1>Add Technician</h1>
<form action='addTechnician.php' method='post' id='aligned'>
    <label for='first_name'>First Name:</label>
    <input type='text' id='first_name' name='first_name'><br><br>
    <label for='last_name'>Last Name:</label>
    <input type='text' id='last_name' name='last_name'><br><br>
    <label for='email'>Email:</label>
    <input type='email' id='email' name='email'><br><br>
    <label for='phone'>Phone:</label>
    <input type="tel" id="phone" name="phone" maxlength="10" pattern="\d{10}" title="10-digit numbers only"><br><br>
    <label for='password'>Password:</label>
    <input type='password' id='password' name='password'><br><br>
    <input type='submit' value='Add Technician' style="margin-left: 145px">
</form>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>
