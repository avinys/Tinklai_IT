<?php
session_start(); // Įjungiame sesiją

// Patikriname, ar vartotojas yra prisijungęs ir kokia jo rolė
$isLoggedIn = isset($_SESSION['user_id']);
$userType = $_SESSION['role'] ?? ''; // "Paprastas", "Naikintojas" arba "Administratorius"
?>

<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradžia - Sosnovskio Barščių Registravimo Sistema</title>
    <link rel="stylesheet" href="/styles/global.css">
</head>

<body>

<?php
include '../views/header.php';
?>

<main class="main-content container">
    <?php if (!$isLoggedIn): ?>
        <h2 class="mb-2">Sveiki atvykę į Sosnovskio Barščių Registravimo Sistemą</h2>
        <p class="mb-3">Ši sistema leidžia registruotiems naudotojams įkelti nuotraukas ir nurodyti vietoves, kuriose auga Sosnovskio barščiai.</p>

        <section class="mb-3">
            <h3 class="mb-2">Pagrindinės funkcijos</h3>
            <ul>
                <li>Įkelkite nuotraukas ir nurodykite apytikslį plotą.</li>
                <li>Nurodykite vietos duomenis, tokius kaip apskritis, savivaldybė, miestas ir gatvė.</li>
                <li>Visi naudotojai gali įkelti Sosnovskio Barščių augimo vietą, tik naikintojai gali pažymėti plotą išnaikintu.</li>
            </ul>
        </section>

        <section>
            <h3 class="mb-2">Papildomos funkcijos</h3>
            <ul>
                <li>Automatiškai ištraukite GPS koordinates iš nuotraukos meta duomenų (jei jos yra). X</li>
                <li>Peržiūrėkite vietoves žemėlapyje arba istorijos registre. X</li>
            </ul>
        </section>
    <?php else: ?>
        <h2 class="mb-2">Sveiki, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Pasirinkite vieną iš veiksmų meniu, esantį viršuje.</p>
    <?php endif; ?>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</body>

</html>
