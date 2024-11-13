<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Ensure the path to your global.css is correct -->
</head>

<body>

<?php
include '../views/header.php'; // Include the header file
?>

<main class="main-content container text-center">
    <h2 class="mb-2">Registracija</h2>
    <form action="index.php?page=process-register" method="POST" class="mb-3" style="width: 70%; max-width: 800px;">
        <div class="mb-2">
            <label for="name" class="form-label">Vardas:</label>
            <input type="text" id="name" name="name" class="form-input" required>
        </div>

        <div class="mb-2">
            <label for="surname" class="form-label">Pavardė:</label>
            <input type="text" id="surname" name="surname" class="form-input" required>
        </div>

        <div class="mb-2">
            <label for="email" class="form-label">El. paštas:</label>
            <input type="email" id="email" name="email" class="form-input" required>
        </div>

        <div class="mb-2">
            <label for="password" class="form-label">Slaptažodis:</label>
            <input type="password" id="password" name="password" class="form-input" required>
        </div>

        <div class="mb-2">
            <label for="destroy" class="form-label">Ar registruojatės kaip naikintojas:</label>
            <input type="checkbox" id="destroy" name="destroy">
        </div>

        <button type="submit" class="button">Registruotis</button>
    </form>
    <p>Jau turi paskyrą? <a href="index.php?page=login">Prisijunk čia</a></p>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</body>

</html>
