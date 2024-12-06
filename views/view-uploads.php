<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Mano Įkėlimai</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>

<body>

    <?php include '../views/header.php'; ?>
    <?php include '../views/alert.php'; ?>

    <main class="main-content container" style="min-width:1000px;">
        <h2 class="mb-2 text-center">Mano Įkėlimai</h2>

        <?php if (empty($uploads)): ?>
            <p class="text-center">Nėra įkeltų vietų.</p>
        <?php else: ?>
            <table class="table">
                <tr >
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
                        <td style="padding: 0; max-height:150px; max-width: 150px;"><img style="height: 100%; width: 100%; object-fit: contain;" src="../public<?= htmlspecialchars($upload['Nuotrauka']) ?>" alt="Nuotrauka" width="100" /></td>
                        <td><?= htmlspecialchars($upload['Miestas_Kaimas']) ?></td>
                        <td><?= htmlspecialchars($upload['Gatve']) ?></td>
                        <td><?= htmlspecialchars($upload['Plotas']) ?></td>
                        <td><?= htmlspecialchars($upload['apskritis']) ?></td>
                        <td><?= htmlspecialchars($upload['savivaldybe']) ?></td>
                        <!-- <td><?= htmlspecialchars($upload['fk_Koordinate']) ?></td> -->
                        <td>
                            <?php if (!empty($upload['platuma']) && !empty($upload['ilguma'])): ?>
                                <?= htmlspecialchars($upload['platuma']) ?>, <?= htmlspecialchars($upload['ilguma']) ?>
                            <?php else: ?>
                                Koordinačių ištraukti nepavyko
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($upload['Kurimo_data']) ?></td>
                        <td >
                            <div style="display: flex; flex-direction: column;">
                            <?php if ($upload['Naikinimo_data'] === null): ?>
                                <a href="index.php?page=edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" class="button">Redaguoti</a>
                                <?php if(!empty($upload['platuma']) && !empty($upload['ilguma'])) { ?>
                                    <a href="index.php?page=view-map&from=view-uploads&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" class="button">Peržiūrėti žemėlapyje</a>
                                <?php } ?>
                            <?php else: ?>
                                <a class="button" style="color: #999; pointer-events: none; background-color: #e0e0e0;">Panaikinta</a>
                            <?php endif; ?>

                            <?php if ($upload['owner'] == true): ?>
                                <a href="index.php?page=delete-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" class="button-alt" style="margin-top:10px;" onclick=" return confirm('Ar tikrai norite ištrinti šią vietą?');">Ištrinti</a>
                            <?php endif; ?>
                            </div>
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