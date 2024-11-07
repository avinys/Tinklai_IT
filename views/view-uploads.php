<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Mano Įkėlimai</title>
</head>
<body>

<?php include '../views/header.php'; ?>

<h2>Mano Įkėlimai</h2>

<?php if (empty($uploads)): ?>
    <p>Nėra įkeltų vietų.</p>
<?php else: ?>
    <table border="1">
        <tr>
            <th>Nuotrauka</th>
            <th>Miesto/Kaimo pavadinimas</th>
            <th>Gatvė</th>
            <th>Plotas (m²)</th>
            <th>Apskritis</th>
            <th>Savivaldybė</th>
            <th>Koordinatės</th>
            <th>Data</th>
            <th>Veiksmai</th>
        </tr>
        <?php foreach ($uploads as $upload): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($upload['photo_path']) ?>" alt="Nuotrauka" width="100"></td>
                <td><?= htmlspecialchars($upload['Miestas_Kaimas']) ?></td>
                <td><?= htmlspecialchars($upload['Gatve']) ?></td>
                <td><?= htmlspecialchars($upload['Plotas']) ?></td>
                <td><?= htmlspecialchars($upload['fk_Apskritis']) ?></td>
                <td><?= htmlspecialchars($upload['fk_Savivaldybe']) ?></td>
                <td><?= htmlspecialchars($upload['fk_Koordinate']) ?></td>
                <td><?= htmlspecialchars($upload['Kurimo_data']) ?></td>
                <td>
                    <a href="index.php?page=edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>">Redaguoti</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>
