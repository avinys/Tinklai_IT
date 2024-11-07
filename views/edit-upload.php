<!-- edit_upload.php -->
<?php include '../views/header.php'; ?>

<h2>Redaguoti Įrašą</h2>
<form action="index.php?page=process-edit-upload&id=<?= htmlspecialchars($upload['id_Vieta']) ?>" method="POST" enctype="multipart/form-data">
    <div>
        <label for="photo">Atnaujinti Nuotrauką:</label>
        <input type="file" id="photo" name="photo" accept="image/*">
    </div>

    <div>
            <label for="region">Apskritis:</label>
            <select name="region" id="region" onchange="fetchMunicipalities(this.value)">
                <option value="">Pasirinkite apskritį</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= htmlspecialchars($region['id']) ?>"><?= htmlspecialchars($region['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="municipality">Savivaldybė:</label>
            <select id="municipality" name="municipality">
                <option value="">Pasirinkite savivaldybę</option>
            </select>
        </div>

    <div>
        <label for="village">Miestas/Kaimas:</label>
        <input type="text" id="village" name="village" value="<?= htmlspecialchars($upload['Miestas_Kaimas']) ?>" required>
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
