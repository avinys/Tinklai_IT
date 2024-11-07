<!-- header.php -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <h1>Sosnovskio Barščių Registravimo Sistema</h1>
    <nav>
        <a href="index.php?page=home">Pradžia</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?page=logout">Atsijungti</a>
                <a href="index.php?page=upload">Įkelti nuotrauką</a>
                <a href="index.php?page=view-uploads">Peržiūrėti pažymėtas vietas</a>
            <?php if ($_SESSION['role'] === 'Naikintojas'): ?>
                <a href="index.php?page=delete-photos">Atliktas naikinimas</a>
            <?php elseif ($_SESSION['role'] === 'Administratorius'): ?>
                <a href="index.php?page=assign-permits">Sukurti naikinimo leidimą</a>
                <a href="index.php?page=view-permits">Peržiūrėti naikinimo leidimus</a>
                <a href="index.php?page=view-eradication-managers">Peržiūrėti naikintojus</a>
                <a href="index.php?page=view-users">Peržiūrėti naudotojus</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="index.php?page=login">Prisijungti</a>
            <a href="index.php?page=register">Registracija</a>
        <?php endif; ?>
    </nav>
</header>
