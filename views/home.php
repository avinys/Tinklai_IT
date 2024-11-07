<?php
session_start(); // Įjungiame sesiją

// Patikriname, ar vartotojas yra prisijungęs ir kokia jo rolė
$isLoggedIn = isset($_SESSION['user_id']);
$userType = $_SESSION['role'] ?? ''; // "Paprastas", "Naikintojas" arba "Administratorius"
print_r($_SESSION);

?>

<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pradžia - Sosnovskio Barščių Registravimo Sistema</title>
    <!-- <link rel="stylesheet" href="/css/styles.css"> Prireikus koreguokite kelią pagal projektą -->
</head>

<body>

<?php
include '../views/header.php';
?>

    <main>
        <?php if (!$isLoggedIn): ?>
            <h2>Sveiki atvykę į Sosnovskio Barščių Registravimo Sistemą</h2>
            <p>Ši sistema leidžia registruotiems naudotojams įkelti nuotraukas ir nurodyti vietoves, kuriose auga Sosnovskio barščiai.</p>

            <section>
                <h3>Pagrindinės funkcijos</h3>
                <ul>
                    <li>Įkelkite nuotraukas ir nurodykite apytikslę užkrėstą plotą.</li>
                    <li>Nurodykite vietos duomenis, tokius kaip savivaldybė, miestas, rajonas, kaimas ir gatvė.</li>
                    <li>Administratoriai gali priskirti vartotojus kaip naikinimo vadovus, kad registruotų tvarkymo datas užkrėstose vietose.</li>
                </ul>
            </section>

            <section>
                <h3>Papildomos funkcijos</h3>
                <ul>
                    <li>Automatiškai ištraukite GPS koordinates iš nuotraukos meta duomenų (jei jos yra).</li>
                    <li>Peržiūrėkite vietoves žemėlapyje arba istorijos registre.</li>
                </ul>
            </section>
        <?php else: ?>
            <h2>Sveiki, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>Pasirinkite vieną iš veiksmų meniu, esantį viršuje.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
    </footer>

</body>

</html>