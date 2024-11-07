<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Įkelti Sosnovskio Barščių Augimo Vietą</title>
</head>

<body>

    <?php
    include '../views/header.php'; // Include the header file
    ?>

    <h2>Įkelti Sosnovskio Barščių Augimo Vietą</h2>
    <form action="index.php?page=process-upload" method="POST" enctype="multipart/form-data">
        <div>
            <label for="photo">Nuotrauka:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required onchange="previewPhoto(event)">
            <img id="currentPhoto" style="display: none; max-width: 800px; margin-top: 10px;">
        </div>

        <!-- Dropdowns populated from the database -->
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
                <!-- Options will be dynamically populated based on region selection -->
            </select>
        </div>

        <div>
            <label for="city">Miestas / Kaimas:</label>
            <input type="text" id="city" name="city" placeholder="Įveskite miesto ar kaimo pavadinimą">
        </div>

        <div>
            <label for="street">Gatvė:</label>
            <input type="text" id="street" name="street" placeholder="Įveskite gatvės pavadinimą">
        </div>

        <div>
            <label for="area">Apytikslis plotas (m&sup2):</label>
            <input type="number" step="1" min="1" id="area" name="area" placeholder="10">
        </div>

        <button type="submit">Įkelti</button>
    </form>
    <script src="/scripts/fetchMunicipalities.js"></script>
    <script src="/scripts/photoPreview.js"></script>     

</body>

</html>
