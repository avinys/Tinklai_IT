<?php
require_once '../src/AuthController.php';
$authController = new AuthController();

switch ($page) {
    case 'login':
        require '../views/login.php';
        break;
    case 'register':
        require '../views/register.php';
        break;
    case 'process-login':
        $authController->login();
        break;
    case 'process-register':
        $authController->register();
        break;
    case 'logout':
        $authController->logout();
        break;
}
