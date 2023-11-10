<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="icon" type="image/ico" href="images/favicon.ico">
</head>
<?php include 'view/header.php'; ?>
<!-- Testing -->
<!-- Test 10/22 ND -->
<main>
    <nav>

    <h2>Administrators</h2>
    <ul>
        <li><a href="product_manager/products.php">Manage Products</a></li>
        <li><a href="technicians/technician.php">Manage Technicians</a></li>
        <li><a href="customer_manager/selectCustomer.php">Manage Customers</a></li>
        <li><a href="under_construction.php">Create Incident</a></li>
        <li><a href="under_construction.php">Assign Incident</a></li>
        <li><a href="under_construction.php">Display Incidents</a></li>
    </ul>

    <h2>Technicians</h2>    
    <ul>
        <li><a href="under_construction.php">Update Incident</a></li>
    </ul>

    <h2>Customers</h2>
    <ul>
        <li><a href="product_manager/registerProductLogin.php">Register Product</a></li>
    </ul>
    
    </nav>
</main>
<?php include 'view/footer.php'; ?>