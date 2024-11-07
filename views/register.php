<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
</head>

<body>

<?php
include '../views/header.php'; // Include the header file
?>


    <h2>Register</h2>
    <form action="index.php?page=process-register" method="POST">
        <div>
            <label for="name">Vardas:</label>
            <input type="text" id="name" name="name" required><br>
        </div>

        <div>
            <label for="surname">Pavardė:</label>
            <input type="text" id="surname" name="surname" required><br>
        </div>


        <div>
            <label for="email">El. paštas:</label>
            <input type="email" id="email" name="email" required><br>
        </div>

        <div>
            <label for="password">Slaptažodis:</label>
            <input type="password" id="password" name="password" required><br>
        </div>

        <div>
            <label for="destroy">Ar registruojatės kaip naikintojas:</label>
            <input type="checkbox" id="destroy" name="destroy"><br>
        </div>

        <button type="submit">Registruotis</button>
    </form>
    <p>Jau turi paskyrą? <a href="index.php?page=login">Prisijunk čia</a></p>
</body>

</html>