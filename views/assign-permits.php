<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Priskirti Naikinimo Leidimus</title>
    <style>
        .container {
            display: flex;
        }
        .list {
            width: 50%;
            padding: 10px;
        }
        .list h3 {
            margin-bottom: 10px;
        }
        .list label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<?php include '../views/header.php'; ?>

<h2>Priskirti Naikinimo Leidimus</h2>

<form action="index.php?page=assign-permits" method="POST">
    <div class="container">
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
    
    <button type="submit">Priskirti Leidimus</button>
</form>

</body>
</html>
