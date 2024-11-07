<?php
// Autoload dependencies and configuration
require_once '../config/config.php';
require_once '../src/helpers.php';

// Get the page from the query parameter
$page = $_GET['page'] ?? 'home';

// Route based on the page category
if (in_array($page, ['login', 'register', 'process-login', 'process-register', 'logout'])) {
    require '../routes/authRoutes.php';
} elseif (in_array($page, ['view-users', 'delete-user', 'edit-user'])) {
    require '../routes/userRoutes.php';
}elseif(in_array($page, ['upload', 'fetch-municipalities', 'process-upload', 'view-uploads', 'edit-upload', 'process-edit-upload'])) {
    require '../routes/uploadRoutes.php';
} elseif(in_array($page, ['assign-permits', 'view-permits', 'delete-permit'])){ 
    require '../routes/eradicationRoutes.php';
}else {
    require '../routes/generalRoutes.php';
}
