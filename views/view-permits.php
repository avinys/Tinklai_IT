<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Visi Naikinimo Leidimai</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .delete-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include '../views/header.php'; ?>

<h2>Visi Naikinimo Leidimai</h2>

<?php if (isset($_GET['status']) && $_GET['status'] === 'deleted'): ?>
    <p style="color: green;">Leidimas sėkmingai ištrintas.</p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Vieta (Miestas/Kaimas, Gatvė)</th>
            <th>Naikintojas</th>
            <th>Administratorius</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permits as $permit): ?>
            <tr>
                <td><?= htmlspecialchars($permit['assigned_date']) ?></td>
                <td><?= htmlspecialchars($permit['place_city']) ?>, <?= htmlspecialchars($permit['place_street']) ?></td>
                <td><?= htmlspecialchars($permit['eradicator_name']) ?> <?= htmlspecialchars($permit['eradicator_surname']) ?></td>
                <td><?= htmlspecialchars($permit['admin_name']) ?> <?= htmlspecialchars($permit['admin_surname']) ?></td>
                <td>
                    <form action="index.php?page=delete-permit&id=<?= htmlspecialchars($permit['permit_id']) ?>" method="POST" style="display:inline;">
                        <button type="submit" class="delete-button" onclick="return confirm('Ar tikrai norite ištrinti šį leidimą?');">Ištrinti</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
