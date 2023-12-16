<?php
session_start();
if (! empty($_SESSION["Email"])) header("Location: createIncident.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Incident Login</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>
<body>
<?php include '../view/header.php'; ?>
<main id="aligned">
    <h1>Get Customer</h1>
    <p>You must enter the customer's full email address to select the customer.</p>
    <form action="createIncident.php" method="post">
        <label for="email" style="width: auto">Email: </label>
        <input type="email" id='email' name='email'><input type="submit" name="Login"><br>
    </form>
</main>
<?php include '../view/footer.php'; ?>
</body>
</html>

