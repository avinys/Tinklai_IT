<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Priskirti Naikinimo Leidimus</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Correct path to the CSS file -->
    <style>
        .list {
            width: 50%;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .list h3 {
            margin-bottom: 15px;
            color: #2e7d32;
            text-align: center;
        }

        .list label {
            display: block;
            margin-bottom: 8px;
            font-weight: normal;
        }
    </style>
</head>

<body>

    <?php include '../views/header.php'; ?>

    <main class="main-content container text-center">
        <h2 class="mb-3">Priskirti Naikinimo Leidimus</h2>

        <form action="index.php?page=assign-permits" method="POST" class="mb-3">
            <div class="container" style="display:flex; justify-content: space-between; gap: 20px;">
                <div class="list">
                    <h3>Pasirinkite Vietas</h3>
                    <?php foreach ($places as $place): ?>
                        <label>
                            <input type="checkbox" name="places[]" value="<?= htmlspecialchars($place['id_Vieta']) ?>">
                            <?= htmlspecialchars($place['Miestas_Kaimas']) ?>, <?= htmlspecialchars($place['Gatve']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="list">
                    <h3>Pasirinkite Naikintojus</h3>
                    <?php foreach ($eradicators as $eradicator): ?>
                        <label>
                            <input type="checkbox" name="eradicators[]" value="<?= htmlspecialchars($eradicator['id_Naudotojas']) ?>">
                            <?= htmlspecialchars($eradicator['Vardas']) ?> <?= htmlspecialchars($eradicator['Pavarde']) ?>, <?= htmlspecialchars($eradicator['El_pastas']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="button mt-3">Priskirti Leidimus</button>
            </div>
        </form>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
    </footer>
</body>

</html>