<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<main id="aligned">
    <nav>
        <h2>Admin menu</h2>
        <ul>
            <li><a href="../product_manager/products.php">Manage Products</a></li>
            <li><a href="../technicians/technician.php">Manage Technicians</a></li>
            <li><a href="../customer_manager/selectCustomer.php">Manage Customers</a></li>
            <li><a href="../incident/displayIncident.php">Display Incidents</a></li>
        </ul>
        <?php
        session_start();
        if ($_SESSION['validAdmin'] = true && isset($_SESSION['username'])) {
            echo "<br><span>"."You are signed in as ".$_SESSION['username']."</span>";
            echo "<br><form action='../loginLogout/logout.php' method='post'><input type='submit' value='Log Out' name='LogOut'></form>";
        }
        else header("Location: ../index.php");
        ?>
    </nav>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>

