<?php
switch ($page) {
    case 'home':
    case '/':
        require '../views/home.php';
        break;
    case 'unauthorized':
        require '../views/unauthorized.php';
        break;
    default:
        http_response_code(404);
        require '../views/404.php';
        break;
}
