<?php
require_once '../config/config.php';
require_once '../src/helpers.php';

class UsersController
{
    public function viewUsers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $pdo = getDatabaseConnection();
        
        // Get filter type from query parameter
        $type = $_GET['type'] ?? null;

        // Prepare the query based on the filter type
        if ($type === 'Naikintojas') {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas = 'Naikintojas'");
            $stmt->execute();
        } elseif ($type === 'Paprastas') {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas = 'Paprastas'");
            $stmt->execute();
        } elseif($type === 'Administratorius'){
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas = 'Administratorius' AND id_Naudotojas != :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE id_Naudotojas != :id");
            $stmt->execute(['id' => $_SESSION['user_id']]);
        }

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pass the users to the view
        include '../views/view-users.php';
    }

    public function deleteUser($id)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("DELETE FROM Naudotojai WHERE id_Naudotojas = :id");
        $stmt->execute(['id' => $id]);

        // Redirect to the users list after deletion
        header("Location: index.php?page=view-users");
        exit();
    }

    public function viewEditUser($id) {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM naudotojai WHERE id_Naudotojas = :id");
        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $types = ['Administratorius', 'Paprastas', 'Naikintojas'];
        include '../views/edit-user.php';
    }

    public function processEditUser($id)
    {
        $type = sanitize($_POST['type']);
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("UPDATE Naudotojai SET Tipas = :type WHERE id_Naudotojas = :id");
        $stmt->execute(['id' => $id, 'type' => $type]);

        // Redirect to the users list after updating
        header("Location: index.php?page=view-users");
        exit();
    }
}
