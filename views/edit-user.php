<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Redaguoti Naudotoją</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>
<body>

<?php include '../views/header.php'; ?>

<main class="main-content container text-center">
    <h2 class="mb-2">Redaguoti Naudotoją</h2>

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
            <tr>
                <td><?= htmlspecialchars($user['id_Naudotojas']) ?></td>
                <td><?= htmlspecialchars($user['Vardas']) ?></td>
                <td><?= htmlspecialchars($user['Pavarde']) ?></td>
                <td><?= htmlspecialchars($user['El_pastas']) ?></td>
                <form action="index.php?page=edit-user&id=<?= htmlspecialchars($user['id_Naudotojas']) ?>" method="POST">
                    <td>
                        <select name="type" class="form-input">
                            <?php foreach ($types as $type): ?>
                                <option value="<?= htmlspecialchars($type) ?>" <?= $user['Tipas'] == $type ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <button type="submit" class="button">Pakeisti</button>
                    </td>
                </form>
            </tr>
        </tbody>
    </table>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</body>
</html>
