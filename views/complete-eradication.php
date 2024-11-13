<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Naikinimo Užbaigimas</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Adjust path if necessary -->
</head>
<body>

<?php include '../views/header.php'; ?>

<main class="main-content container">
    <h2 class="mb-2 text-center">Naikinimo Užbaigimas</h2>

    <section class="mb-3">
        <h3>Leidimo ir Vietos Informacija</h3>
        <table class="table">
            <tr>
                <th>Leidimo ID</th>
                <td><?= htmlspecialchars($permit['permit_id']) ?></td>
            </tr>
            <tr>
                <th>Data</th>
                <td><?= htmlspecialchars($permit['date']) ?></td>
            </tr>
            <tr>
                <th>Apskritis</th>
                <td><?= htmlspecialchars($permit['region']) ?></td>
            </tr>
            <tr>
                <th>Savivaldybė</th>
                <td><?= htmlspecialchars($permit['municipality']) ?></td>
            </tr>
            <tr>
                <th>Miestas/Kaimas</th>
                <td><?= htmlspecialchars($permit['city']) ?></td>
            </tr>
            <tr>
                <th>Gatvė</th>
                <td><?= htmlspecialchars($permit['street']) ?></td>
            </tr>
            <tr>
                <th>Plotas (m²)</th>
                <td><?= htmlspecialchars($permit['area']) ?></td>
            </tr>
            <tr>
                <th>Koordinatės</th>
                <td>
                    <?php if (!empty($permit['latitude']) && !empty($permit['longitude'])): ?>
                        <?= htmlspecialchars($permit['latitude']) ?>, <?= htmlspecialchars($permit['longitude']) ?>
                    <?php else: ?>
                        Koordinaciu istraukti nepavyko
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </section>

    <form action="index.php?page=submit-eradication" method="POST">
        <input type="hidden" name="permit_id" value="<?= htmlspecialchars($permit['permit_id']) ?>">
        <div class="form-group mb-3">
            <label for="eradication_date">Naikinimo Data:</label>
            <input type="date" id="eradication_date" name="eradication_date" class="form-input" required>
            <label class="form-check-label">
                <input type="checkbox" id="use_current_date" name="use_current_date" class="form-check-input">
                Naudoti šiandienos datą
            </label>
        </div>

        <button type="submit" class="button">Žymėti kaip išnaikintą</button>
    </form>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

<script>
    // Automatically fill in today's date if the checkbox is checked
    document.getElementById('use_current_date').addEventListener('change', function() {
        const dateField = document.getElementById('eradication_date');
        if (this.checked) {
            const today = new Date().toISOString().split('T')[0];
            dateField.value = today;
            dateField.disabled = true;
        } else {
            dateField.disabled = false;
            dateField.value = '';
        }
    });
</script>

</body>
</html>
