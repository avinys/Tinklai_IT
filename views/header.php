<!-- header.php -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
    <h1 class="header-title">Sosnovskio Barščių Registravimo Sistema</h1>
    <nav class="nav">
        <a href="index.php?page=home" class="nav-link">Pradžia</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php?page=logout" class="nav-link">Atsijungti</a>
            <a href="index.php?page=upload" class="nav-link">Įkelti nuotrauką</a>
            <a href="index.php?page=view-uploads" class="nav-link">Peržiūrėti pažymėtas vietas</a>
            <?php if ($_SESSION['role'] === 'Naikintojas'): ?>
                <a href="index.php?page=view-assigned-permits" class="nav-link">Atlikti naikinimą</a>
            <?php elseif ($_SESSION['role'] === 'Administratorius'): ?>
                <a href="index.php?page=assign-permits" class="nav-link">Sukurti naikinimo leidimą</a>
                <a href="index.php?page=view-permits" class="nav-link">Peržiūrėti naikinimo leidimus</a>
                <a href="index.php?page=view-users" class="nav-link">Peržiūrėti naudotojus</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="index.php?page=login" class="nav-link">Prisijungti</a>
            <a href="index.php?page=register" class="nav-link">Registracija</a>
        <?php endif; ?>
    </nav>
</header>
