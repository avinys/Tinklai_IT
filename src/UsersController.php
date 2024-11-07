<?php
require_once '../config/config.php';
require_once '../src/helpers.php';

class UsersController
{
    public function viewUsers()
    {
        $pdo = getDatabaseConnection();
        
        // Get filter type from query parameter
        $type = $_GET['type'] ?? null;

        // Prepare the query based on the filter type
        if ($type === 'Naikintojas') {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas = 'Naikintojas'");
        } elseif ($type === 'Paprastas') {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas = 'Paprastas'");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE Tipas != 'Administratorius'");
        }

        $stmt->execute();
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

    public function editUser($id, $newType)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("UPDATE Naudotojai SET Tipas = :type WHERE id_Naudotojas = :id");
        $stmt->execute(['id' => $id, 'type' => $newType]);

        // Redirect to the users list after updating
        header("Location: index.php?page=view-users");
        exit();
    }
}
