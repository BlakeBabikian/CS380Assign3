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
<body>
<?php include '../view/header.php'; ?>
<?php
    require '../errors/testInput.php';
    $person_data = []; # set array
    $con = null;
    foreach ($_POST as $key => $value) { # key = input name # value = input value
        if ($value === "") { # if no value assigned, enter
            echo "<h4 style='color: red;' id='aligned'>".'No '.$key.' inputed'."</h4>"; # error output
        }
        else {
            $test = test_input($value); # this function will return true if the input is valid
            if ($test === true) {
                $person_data[] = $value;
            }
            else {
                echo "<h4 style='color: red;' id='aligned'>".$test."</h4>";
            }
        }
    }
    if (sizeof($person_data) == 5) { # this is to prevent the sql from running if there is an empty field
        require '../model/database.php';
        $sql = array(
            "USE bbabikian;",
            "INSERT INTO technicians (firstName, lastName, email, phone, password) 
             VALUES ('$person_data[0]', 
                     '$person_data[1]', 
                     '$person_data[2]', 
                     '$person_data[3]', 
                     '$person_data[4]');");
        
            try{
                for ($i = 0; $i<sizeof($sql); $i++){
                    $query = $sql[$i];
                    mysqli_query($con, $query);
                }

            } catch(Exception $e) { echo "<h4 style='color: red;' id='aligned'>" . "Error: " .$e->getMessage() .
                "<br/>Line" . $e->getLine() . "</h4>";}
            finally { 
                mysqli_close($con);
            }
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
        <input type='tel' id='phone' name='phone'><br><br>

        <label for='password'>Password:</label>
        <input type='password' id='password' name='password'><br><br>

        <input type='submit' value='Add Technician' style="margin-left: 145px">
</form>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>
