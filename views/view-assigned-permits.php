<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Priskirti Leidimai</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Adjust path if necessary -->
</head>

<body>

    <?php include '../views/header.php'; ?>
    <?php include '../views/alert.php'; ?>

    <main class="main-content container" style="min-width:1000px;">
        <h2 class="mb-2 text-center">Priskirti Leidimai</h2>

        <table class="table">
            <thead>
                <tr>
                    <!-- <th>Data</th> -->
                    <th>Apskritis</th>
                    <th>Savivaldybė</th>
                    <th>Miestas/Kaimas</th>
                    <th>Gatvė</th>
                    <th>Plotas (m²)</th>
                    <th>Nuotrauka</th>
                    <th>Koordinatės</th>
                    <th>Veiksmai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($places as $place): ?>
                    <tr>
                        <!-- <td><?= htmlspecialchars($place['date']) ?></td> -->
                        <td><?= htmlspecialchars($place['region']) ?></td>
                        <td><?= htmlspecialchars($place['municipality']) ?></td>
                        <td><?= htmlspecialchars($place['city']) ?></td>
                        <td><?= htmlspecialchars($place['street']) ?></td>
                        <td><?= htmlspecialchars($place['area']) ?> m²</td>
                        <td style="padding: 0; text-align: center;">
                            <?php if (!empty($place['photoPath'])): ?>
                                <img src="<?= htmlspecialchars($place['photoPath']) ?>" alt="Nuotrauka" width="100">
                            <?php else: ?>
                                Nėra nuotraukos
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($place['platuma']) && !empty($place['ilguma'])): ?>
                                <?= htmlspecialchars($place['platuma']) ?>, <?= htmlspecialchars($place['ilguma']) ?>
                            <?php else: ?>
                                Koordinačių ištraukti nepavyko
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="index.php?page=complete-eradication&id=<?= htmlspecialchars($place['permit_id']) ?>" class="button">Naikinti</a>
                        </td>
                        <!-- <form action="index.php?page=complete-eradication&id=<?= htmlspecialchars($place['permit_id']) ?>" method="POST">
                            <button type="submit" onclick="">Naikinti</button>
                        </form> -->
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