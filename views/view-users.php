<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Naudotojų sąrašas</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>
<body>

<?php include '../views/alert.php'; ?>
<?php include '../views/header.php'; ?>

<main class="main-content container">
    <h2 class="mb-2 text-center">Naudotojų sąrašas</h2>

    <div class="filters text-center mb-3" style="display:flex; justify-content: space-between;">
        <a href="index.php?page=view-users&type=Naikintojas">Filtruoti tik naikintojus</a>
        <a href="index.php?page=view-users&type=Paprastas">Filtruoti tik paprastus</a>
        <a href="index.php?page=view-users&type=Administratorius">Filtruoti tik administratorius</a>
        <a href="index.php?page=view-users">Rodyti visus</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavardė</th>
                <th>El. paštas</th>
                <th>Tipas</th>
                <th>Veiksmai</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id_Naudotojas']) ?></td>
                    <td><?= htmlspecialchars($user['Vardas']) ?></td>
                    <td><?= htmlspecialchars($user['Pavarde']) ?></td>
                    <td><?= htmlspecialchars($user['El_pastas']) ?></td>
                    <td><?= htmlspecialchars($user['Tipas']) ?></td>
                    <td style="text-align: center;">
                        <a href="index.php?page=edit-user&id=<?= $user['id_Naudotojas'] ?>" class="button">Redaguoti tipą</a> |
                        <a href="index.php?page=delete-user&id=<?= $user['id_Naudotojas'] ?>" class="button-alt delete-button" onclick="return confirm('Ar tikrai norite ištrinti šį vartotoją?');">Ištrinti</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</body>
</html>
