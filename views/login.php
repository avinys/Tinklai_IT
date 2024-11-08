<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungimas</title>
</head>

<body>

<?php
include '../views/header.php'; // Include the header file
?>

    <h2>Prisijungimas</h2>
    <form action="index.php?page=process-login" method="POST">
        <div>
            <label for="email">El. paštas:</label>
            <input type="email" id="email" name="email" required><br>
        </div>

        <div>
            <label for="password">Slaptažodis:</label>
            <input type="password" id="password" name="password" required><br>
        </div>

        <button type="submit">Prisijungti</button>
    </form>
    <p>Neturite paskyros? <a href="index.php?page=register">Registruokitės čia</a></p>
</body>

</html>
