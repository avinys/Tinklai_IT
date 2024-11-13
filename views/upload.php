<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Įkelti Sosnovskio Barščių Augimo Vietą</title>
    <link rel="stylesheet" href="/styles/global.css"> <!-- Correct path to the CSS file -->
</head>

<body>

<?php
include '../views/header.php'; // Include the header file
?>

<main class="main-content container text-center">
    <h2 class="mb-2">Įkelti Sosnovskio Barščių Augimo Vietą</h2>
    <form action="index.php?page=process-upload" method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="mb-2">
            <label for="photo" class="form-label">Nuotrauka:</label>
            <input type="file" id="photo" name="photo" class="form-input" accept="image/*" required onchange="previewPhoto(event)">
            <img id="currentPhoto" style="display: none; max-width: 100%; margin-top: 10px;">
        </div>

        <!-- Dropdowns populated from the database -->
        <div class="mb-2">
            <label for="region" class="form-label">Apskritis:</label>
            <select name="region" id="region" class="form-input" onchange="fetchMunicipalities(this.value)">
                <option value="">Pasirinkite apskritį</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= htmlspecialchars($region['id']) ?>"><?= htmlspecialchars($region['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-2">
            <label for="municipality" class="form-label">Savivaldybė:</label>
            <select id="municipality" name="municipality" class="form-input">
                <option value="">Pasirinkite savivaldybę</option>
                <!-- Options will be dynamically populated based on region selection -->
            </select>
        </div>

        <div class="mb-2">
            <label for="city" class="form-label">Miestas / Kaimas:</label>
            <input type="text" id="city" name="city" class="form-input" placeholder="Įveskite miesto ar kaimo pavadinimą">
        </div>

        <div class="mb-2">
            <label for="street" class="form-label">Gatvė:</label>
            <input type="text" id="street" name="street" class="form-input" placeholder="Įveskite gatvės pavadinimą">
        </div>

        <div class="mb-2">
            <label for="area" class="form-label">Apytikslis plotas (m&sup2):</label>
            <input type="number" step="1" min="1" id="area" name="area" class="form-input" placeholder="10">
        </div>

        <button type="submit" class="button">Įkelti</button>
    </form>
</main>

<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

<script src="/scripts/fetchMunicipalities.js"></script>
<script src="/scripts/photoPreview.js"></script>     

</body>

</html>
