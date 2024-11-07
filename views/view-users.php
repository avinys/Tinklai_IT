<body>

<?php
include '../views/header.php';
?>

<h2>Naudotojų sąrašas</h2>
<a href="index.php?page=view-users&type=Naikintojas"><p>Filtruoti tik naikintojus</p></a>
<a href="index.php?page=view-users&type=Paprastas"><p>Filtruoti tik paprastus</p></a>
<a href="index.php?page=view-users"><p>Rodyti paprastus ir naikintojus</p></a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>El. paštas</th>
        <th>Tipas</th>
        <th>Veiksmai</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id_Naudotojas']) ?></td>
        <td><?= htmlspecialchars($user['Vardas']) ?></td>
        <td><?= htmlspecialchars($user['Pavarde']) ?></td>
        <td><?= htmlspecialchars($user['El_pastas']) ?></td>
        <td><?= htmlspecialchars($user['Tipas']) ?></td>
        <td>
            <a href="index.php?page=edit-user&id=<?= $user['id_Naudotojas'] ?>">Redaguoti</a> |
            <a href="index.php?page=delete-user&id=<?= $user['id_Naudotojas'] ?>" onclick="return confirm('Ar tikrai norite ištrinti šį vartotoją?');">Ištrinti</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
