<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Technician Home</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<main id="aligned">
    <?php
    session_start();
    $con = null;
    $dateNull = null;
    require '../model/database.php';

    error_reporting(0);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (! empty($_POST)) {
        foreach ($_POST as $id => $value) { 
            if ($value == "Close") { 
                try {
                    $query = mysqli_prepare($con, "UPDATE incidents SET dateClosed = NOW() WHERE incidentID = ?");
                    mysqli_stmt_bind_param($query, "d", $id);
                    mysqli_stmt_execute($query);} # run query
                catch (Exception $e) {
                    $error = "Error: ".$e->getMessage(); # set message
                    header("Location: ../errors/database_error.php?error_message=$error");}
            }
        }
    }

    try {
        echo "<h1>Select Incident</h1>";
        $query = mysqli_prepare($con, "SELECT * FROM incidents WHERE techID=? AND dateClosed is null;");
        mysqli_stmt_bind_param($query, "d", $_SESSION['techID']);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (!empty($data)) {
            echo "<table id='aligned'>";
            echo "<thead>";
            echo "<tr>";
            foreach (mysqli_fetch_fields($result) as $line) { // Loop through column names
                if ($line->name != "techID" && $line->name != "dateClosed") echo "<th>{$line->name}</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            echo "<form id='closeIncidents' action='techHome.php' method='post'>"; # set up form, with delete buttons at end of each html table row
            foreach ($data as $row) { // Loop through fetched data
                echo "<tr>";
                foreach ($row as $field_name => $field_value) { // Loop through each row's values
                    if ($field_name != "techID" && $field_name != "dateClosed") echo "<td>{$field_value}</td>";
                }
                echo "<td><input type='submit' name='{$row['incidentID']}' value='Close'></td>";
                echo "</tr>";
            }

            echo "</form>";
            echo "</tbody>";
            echo "</table>";
        }
        else {
            echo "There are no open incidents for this technician.";
            echo "<br><a href='techHome.php'>Click here to refresh list.</a><br>";
        }
    }
    catch (Exception $e) {
        $error = "Error: ".$e->getMessage(); # set message
        header("Location: ../errors/database_error.php?error_message=$error");}
    
    if ($_SESSION['ValidTech'] = true && isset($_SESSION['Email'])) {
        echo "<br><span>"."You are signed in as ".$_SESSION['Email']."</span>";
        echo "<br><form action='../loginLogout/logout.php' method='post'><input type='submit' value='Log Out' name='LogOut'></form>";
    }
    else header("Location: ../index.php");
    ?>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>
