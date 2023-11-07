<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register Product</title>
    <meta name="description" content="Your page description">
    <meta name="keywords" content="keywords, for, your, page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<?php include '../view/header.php'; ?>
<h1>Register Product</h1>
<main id="aligned">
    <p>You must sign in to register a product:</p>
    <form action="registerProduct.php" method="post" id="aligned">
        <label for="email" style="width: auto">Email: </label>
        <input type="email" id='email' name='email'><input type="submit" name="Login"><br>
    </form>

</main>
<?php include '../view/footer.php'; ?>
</body>
</html>

