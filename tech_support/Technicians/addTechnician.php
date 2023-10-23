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
<main id='aligned'>
<h1>Add Technician</h1>
<form action='databaseAddTechnician.php' method='post' id='aligned'>
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
