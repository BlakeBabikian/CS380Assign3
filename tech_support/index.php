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
<body>
<header>
    <h1>SportsPro Technical Support</h1>
    <p>Sports management software for the sports enthusiast</p>
</header>
<?php
session_start();
if ($_SESSION['ValidTech']) header("Location: homePages/techHome.php");
elseif ($_SESSION['ValidAdmin']) header("Location: homePages/adminHome.php");
elseif ($_SESSION['ValidCustomer']) header("Location: homePages/customerHome.php");
?>
<main>
    <nav>

    <h2>Main Menu</h2>
    <ul>
        <li><a href="loginLogout/adminLogin.php">Administrators</a></li>
        <li><a href="loginLogout/technicianLogin.php">Technicians</a></li>
        <li><a href="homePages/customerHome.php">Customers</a></li>
    </ul>

    
    </nav>
</main>
<?php include 'view/footer.php'; ?>
</body>
</html>
