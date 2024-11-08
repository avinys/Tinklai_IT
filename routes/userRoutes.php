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
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page']) && $_GET['page'] === 'edit-user' && isset($_GET['id'])){
            $usersController->viewEditUser($_GET['id']);
        }
        elseif (isset($_GET['id']) && 
            $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'edit-user') {
                $usersController->processEditUser($_GET['id'], $_GET['type']);
           }
        break;
}
