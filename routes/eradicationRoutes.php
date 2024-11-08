<?php

require_once '../src/EradicationController.php';
$eradicationController = new EradicationController();

switch ($page) {
    case 'assign-permits':
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['page']) && $_GET['page'] === 'assign-permits') {
            $eradicationController->populatePermitForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'assign-permits') {
            $eradicationController->processAssignPermit();
        }
        break;
    case 'view-permits':
        $eradicationController->viewAllPermits();
        break;
    case 'delete-permit':
        if ($_GET['page'] === 'delete-permit' && isset($_GET['id'])) {
            $eradicationController->deletePermit((int)$_GET['id']);
        }
        break;        

}
