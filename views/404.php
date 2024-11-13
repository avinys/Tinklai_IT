<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puslapis nerastas - Klaida 404</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>
<body>

<?php
session_start();
include '../views/header.php';
?>

<main class="main-content container text-center">
    <h2 class="mb-2">Klaida 404 - Puslapis nerastas</h2>
    <p class="mb-1">Atsiprašome, tačiau puslapis, kurio ieškote, neegzistuoja arba buvo perkeltas.</p>
    <p>Grįžkite į <a href="/index.php?page=home">pagrindinį puslapį</a> arba naudokitės navigacijos nuorodomis aukščiau.</p>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema</p>
</footer>

</body>
</html>
