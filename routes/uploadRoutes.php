<?php

require_once '../src/UploadController.php';
$uploadController = new UploadController();

switch ($page) {
    case 'upload':
        $uploadController->populateUploadForm();
        break;
    case 'process-upload':
        $uploadController->processUpload();
        break;
    case 'fetch-municipalities':
        $uploadController->fetchMunicipalities();
        break;
    case 'view-uploads':
        $uploadController->viewUploads();
        break;
    case 'edit-upload':
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page']) && $_GET['page'] === 'edit-upload') {
            $uploadController->showEditForm($_GET['id']);
        }
        break;
    case 'process-edit-upload':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'process-edit') {
            $uploadController->processEdit($_GET['id']);
        }
        break;
}
