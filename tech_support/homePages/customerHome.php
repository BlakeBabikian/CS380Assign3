<?php
session_start();
if ($_SESSION['ValidCustomer'] = true && isset($_SESSION['Email'])) {
    echo "<br><span>"."You are signed in as ".$_SESSION['Email']."</span>";
    echo "<br><form action='../loginLogout/logout.php' method='post'><input type='submit' value='Log Out' name='LogOut'></form>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Home</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<?php include '../view/header.php'; ?>
<main>
    <nav>

        <h2>Customer Menu</h2>
        <ul>
            <li><a href="../incident/createIncidentLogin.php">Create Incident</a></li>
            <li><a href="../product_manager/registerProductLogin.php">Register Product</a></li>
            <li><a href="../incident/displayIncident.php">Display Incident</a></li>
        </ul>
    </nav>
</main>
<?php include '../view/footer.php'; ?>