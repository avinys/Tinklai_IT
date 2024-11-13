<!-- edit_upload.php -->
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Redaguoti Įrašą</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>
<body>

<?php include '../views/header.php'; ?>

<main class="main-content container text-center">
    <h2 class="mb-2">Redaguoti Įrašą</h2>
    <form action="index.php?page=edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="mb-2">
            <label for="photo" class="form-label">Atnaujinti Nuotrauką:</label>
            <input type="file" id="photo" name="photo" class="form-input" accept="image/*" onchange="previewPhoto(event)">
            
            <!-- Display current photo if available -->
            <?php if (!empty($upload['Nuotrauka'])): ?>
                <img id="currentPhoto" src="<?= htmlspecialchars($upload['Nuotrauka']) ?>" alt="Dabartinė nuotrauka" style="max-width: 100%; display: block; margin-top: 10px;">
            <?php else: ?>
                <img id="currentPhoto" style="display: none; max-width: 100%; margin-top: 10px;">
            <?php endif; ?>
        </div>

        <div class="mb-2">
            <label for="region" class="form-label">Apskritis:</label>
            <select name="region" id="region" class="form-input" onchange="fetchMunicipalities(this.value)">
                <option value="">Pasirinkite apskritį</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= htmlspecialchars($region['id']) ?>" <?= $region['id'] == $upload['fk_Apskritis'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($region['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-2">
            <label for="municipality" class="form-label">Savivaldybė:</label>
            <select id="municipality" name="municipality" class="form-input">
                <option value="">Pasirinkite savivaldybę</option>
                <?php foreach ($municipalities as $municipality): ?>
                    <option value="<?= htmlspecialchars($municipality['id']) ?>" <?= $municipality['id'] == $upload['fk_Savivaldybe'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($municipality['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-2">
            <label for="city" class="form-label">Miestas/Kaimas:</label>
            <input type="text" id="city" name="city" class="form-input" value="<?= htmlspecialchars($upload['Miestas_Kaimas']) ?>" required>
        </div>

        <div class="mb-2">
            <label for="street" class="form-label">Gatvė:</label>
            <input type="text" id="street" name="street" class="form-input" value="<?= htmlspecialchars($upload['Gatve']) ?>" required>
        </div>

        <div class="mb-2">
            <label for="area" class="form-label">Plotas (m²):</label>
            <input type="number" id="area" name="area" class="form-input" value="<?= htmlspecialchars($upload['Plotas']) ?>" min="1" required>
        </div>

        <button type="submit" class="button">Išsaugoti Pakeitimus</button>
    </form>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

<!-- <script src="/scripts/fetchMunicipalities.js"></script>
<script src="/scripts/photoPreview.js"></script>   -->

<script src="../public/scripts/fetchMunicipalities.js"></script>
<script src="../public/scripts/photoPreview.js"></script> 

</body>
</html>
