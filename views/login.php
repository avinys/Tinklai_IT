<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungimas</title>
    <!-- <link rel="stylesheet" href="../styles/global.css"> -->
    <link rel="stylesheet" href="../public/styles/global.css">
</head>

<body>

    <?php
    include '../views/header.php';
    ?>

    <?php
    include '../views/alert.php';
    ?>

    <main class="main-content container text-center">
        <div class=container>
            <h2 class="mb-2">Prisijungimas</h2>
            <form action="index.php?page=process-login" method="POST" class="mb-3" style="width: 70%; max-width: 800px;">
                <div class="mb-2">
                    <label for="email" class="form-label">El. paštas:</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label">Slaptažodis:</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                <div class="actions">
                    <button type="submit" class="button">Prisijungti</button>
                </div>
            </form>
            <p>Neturite paskyros? <a href="index.php?page=register">Registruokitės čia</a></p>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Sosnovskio Barščių Registravimo Sistema. Autorius: Arvydas Vingis</p>
    </footer>

</body>

</html>