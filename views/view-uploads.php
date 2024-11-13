<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Mano Įkėlimai</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Correct path to the CSS file -->
</head>
<body>

<?php include '../views/header.php'; ?>

<main class="main-content container" style="min-width:1000px;">
    <h2 class="mb-2 text-center">Mano Įkėlimai</h2>

    <?php if (empty($uploads)): ?>
        <p class="text-center">Nėra įkeltų vietų.</p>
    <?php else: ?>
        <table class="table">
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
                    <td style="padding: 0;"><img src="<?= htmlspecialchars($upload['Nuotrauka']) ?>" alt="Nuotrauka" width="100"/></td>
                    <td><?= htmlspecialchars($upload['Miestas_Kaimas']) ?></td>
                    <td><?= htmlspecialchars($upload['Gatve']) ?></td>
                    <td><?= htmlspecialchars($upload['Plotas']) ?></td>
                    <td><?= htmlspecialchars($upload['apskritis']) ?></td>
                    <td><?= htmlspecialchars($upload['savivaldybe']) ?></td>
                    <!-- <td><?= htmlspecialchars($upload['fk_Koordinate']) ?></td> -->
                    <td>
                        <?php if (!empty($place['latitude']) && !empty($place['longitude'])): ?>
                            <?= htmlspecialchars($place['latitude']) ?>, <?= htmlspecialchars($place['longitude']) ?>
                        <?php else: ?>
                            Koordinaciu istraukti nepavyko
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($upload['Kurimo_data']) ?></td>
                    <td>
                        <a href="index.php?page=edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" class="button">Redaguoti</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</body>
</html>
