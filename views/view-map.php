<!DOCTYPE html>
<html>

<head>
    <title>Žiūrėti žemėlapyje</title>
    <!-- The callback parameter is required, so we use console.debug as a noop -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=<?= $apiKey ?>&callback=console.debug&libraries=maps,marker&v=beta">
    </script>
    <!-- <link rel="stylesheet" href="/styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        gmp-map {
            height: 90%;
            margin-bottom:2%;
        }
    </style>
</head>

<body>
<?php include '../views/header.php'; ?>
<?php include '../views/alert.php'; ?>
    <main class="main-content container text-center">
        <gmp-map center="<?= $upload['platuma'] ?>,<?= $upload['ilguma'] ?>" zoom="15" map-id="DEMO_MAP_ID">
            <gmp-advanced-marker position="<?= $upload['platuma'] ?>,<?= $upload['ilguma'] ?>" title="Sosnovskių barščių vieta"></gmp-advanced-marker>
        </gmp-map>
        <?php if ($from == "view-uploads") { ?>
            <a href="index.php?page=view-uploads" class="button">Grįžti į vietų peržiūrą</a>
        <?php } else { ?>
            <a href="index.php?page=view-assigned-permits" class="button">Grįžti į leidimų peržiūrą</a>
        <?php }?>
    </main>
</body>
<footer class="footer">
    <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
</footer>

</html>