<?php
session_start();
if (isset($_SESSION['ValidTech']) && isset($_SESSION['Email'])) header("Location: homePages/techHome.php");
elseif (isset($_SESSION['ValidAdmin']) && isset($_SESSION['username'])) header("Location: homePages/adminHome.php");
elseif (isset($_SESSION['ValidCustomer']) && isset($_SESSION['Email'])) header("Location: homePages/customerHome.php");
?>

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
