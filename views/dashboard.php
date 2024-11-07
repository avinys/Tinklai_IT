<?php
// Placeholder for checking user session
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sosnovskio Barščių Registracija</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <h3>Your Reported Locations</h3>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Location</th>
            <th>Area (m²)</th>
            <th>Actions</th>
        </tr>
        <!-- Sample data rows -->
        <tr>
            <td>1</td>
            <td><img src="uploads/photo1.jpg" width="50"></td>
            <td>54.6872, 25.2797</td>
            <td>500</td>
            <td>
                <a href="edit.php?id=1">Edit</a> | 
                <a href="delete.php?id=1">Delete</a>
            </td>
        </tr>
        <!-- End sample data rows -->
    </table>

    <p><a href="upload.php">Add New Location</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
