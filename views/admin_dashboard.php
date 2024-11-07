<?php
// Check if user is an admin
session_start();
if ($_SESSION['role'] !== 'Administratorius') {
    header("Location: index.php?page=home");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sosnovskio Barščių Registracija</title>
</head>
<body>

    
<?php
include '../views/header.php'; // Include the header file
?>


    <h2>Admin Dashboard</h2>
    <h3>All Reported Locations</h3>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Location</th>
            <th>Area (m²)</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <!-- Sample data rows -->
        <tr>
            <td>1</td>
            <td><img src="uploads/photo1.jpg" width="50"></td>
            <td>54.6872, 25.2797</td>
            <td>500</td>
            <td>Reported</td>
            <td>
                <a href="approve.php?id=1">Approve</a> | 
                <a href="delete.php?id=1">Delete</a>
            </td>
        </tr>
        <!-- End sample data rows -->
    </table>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
