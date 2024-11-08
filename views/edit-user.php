<body>

    <?php
    include '../views/header.php';
    ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Vardas</th>
            <th>Pavardė</th>
            <th>El. paštas</th>
            <th>Tipas</th>
            <th>Veiksmai</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($user['id_Naudotojas']) ?></td>
            <td><?= htmlspecialchars($user['Vardas']) ?></td>
            <td><?= htmlspecialchars($user['Pavarde']) ?></td>
            <td><?= htmlspecialchars($user['El_pastas']) ?></td>
            <form action='index.php?page=edit-user&id=<?= $user['id_Naudotojas'] ?>' method='POST'>
                <td>
                    <select name='type'>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= htmlspecialchars($type) ?>" <?= $user['Tipas'] == $type ? 'selected' : '' ?>>
                                <?= htmlspecialchars($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <button type="submit">Pakeisti</a>
                </td>
            </form>
        </tr>
    </table>

</body>