<?php
require_once '../src/UsersController.php';
$usersController = new UsersController();

switch ($page) {
    case 'view-users':
        $usersController->viewUsers();
        break;
    case 'delete-user':
        if (isset($_GET['id'])) {
            $usersController->deleteUser($_GET['id']);
        }
        break;
    case 'edit-user':
        if (isset($_GET['id']) && isset($_GET['type'])) {
            $usersController->editUser($_GET['id'], $_GET['type']);
        }
        break;
}
