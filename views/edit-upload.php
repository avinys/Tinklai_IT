<!-- edit_upload.php -->
<?php include '../views/header.php'; ?>

<h2>Redaguoti Įrašą</h2>
<form action="index.php?page=edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" method="POST" enctype="multipart/form-data">
    <div>
        <label for="photo">Atnaujinti Nuotrauką:</label>
        <input type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)">
        
        <!-- Display current photo if available -->
        <?php if (!empty($upload['Nuotrauka'])): ?>
            <img id="currentPhoto" src="<?= htmlspecialchars($upload['Nuotrauka']) ?>" alt="Dabartinė nuotrauka" style="max-width: 800px; display: block; margin-top: 10px;">
        <?php else: ?>
            <img id="currentPhoto" style="display: none; max-width: 800px; margin-top: 10px;">
        <?php endif; ?>
    </div>

    <div>
        <label for="region">Apskritis:</label>
        <select name="region" id="region" onchange="fetchMunicipalities(this.value)">
            <option value="">Pasirinkite apskritį</option>
            <?php foreach ($regions as $region): ?>
                <option value="<?= htmlspecialchars($region['id']) ?>" <?= $region['id'] == $upload['fk_Apskritis'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($region['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="municipality">Savivaldybė:</label>
        <select id="municipality" name="municipality">
            <option value="">Pasirinkite savivaldybę</option>
            <?php foreach ($municipalities as $municipality): ?>
                <option value="<?= htmlspecialchars($municipality['id']) ?>" <?= $municipality['id'] == $upload['fk_Savivaldybe'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($municipality['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="city">Miestas/Kaimas:</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($upload['Miestas_Kaimas']) ?>" required>
    </div>

    <div>
        <label for="street">Gatvė:</label>
        <input type="text" id="street" name="street" value="<?= htmlspecialchars($upload['Gatve']) ?>" required>
    </div>

    <div>
        <label for="area">Plotas (m²):</label>
        <input type="number" id="area" name="area" value="<?= htmlspecialchars($upload['Plotas']) ?>" min="1" required>
    </div>

    <button type="submit">Išsaugoti Pakeitimus</button>
</form>
<script src="/scripts/fetchMunicipalities.js"></script>
<script src="/scripts/photoPreview.js"></script>  
</script>
