<?php

class EradicationController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function viewAllPermits()
    {
        // Check if user is admin
        if ($_SESSION['role'] != 'Administratorius') {
            header("Location: index.php?page=unauthorized");
            exit();
        }

        // Fetch permits from the database
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("
        SELECT 
            leidimai.id_Leidimas AS permit_id,
            leidimai.Data AS assigned_date,
            vietos.Miestas_Kaimas AS place_city,
            vietos.Gatve AS place_street,
            naudotojai1.Vardas AS eradicator_name,
            naudotojai1.Pavarde AS eradicator_surname,
            naudotojai2.Vardas AS admin_name,
            naudotojai2.Pavarde AS admin_surname
        FROM leidimai
        JOIN vietos ON leidimai.fk_Vieta = vietos.id_Vieta
        JOIN naudotojai naudotojai1 ON leidimai.fk_Naikintojas = naudotojai1.id_Naudotojas
        JOIN naudotojai naudotojai2 ON leidimai.fk_Administratorius = naudotojai2.id_Naudotojas
    ");
        $permits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Load the view to display permits
        include '../views/view-permits.php';
    }

    public function deletePermit($permitId)
    {
        // Check if the user is an admin
        if ($_SESSION['role'] != 'Administratorius') {
            header("Location: index.php?page=unauthorized");
            exit();
        }

        // Delete the permit from the database
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("DELETE FROM leidimai WHERE id_Leidimas = :permit_id");

        if ($stmt->execute(['permit_id' => $permitId])) {
            $_SESSION['alert_message'] = "Naikinimo leidimas ištrintas sėkmingai!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['alert_message'] = "Įvyko klaida. Prašome bandyti dar kartą.";
            $_SESSION['alert_type'] = "error";
        }

        header("Location: index.php?page=view-permits");
        exit();
    }

    public function populatePermitForm()
    {
        // Check if user is admin
        if ($_SESSION['role'] != 'Administratorius') {
            header("Location: index.php?page=unauthorized");
        }

        // Fetch places and eradicators from the database
        $pdo = getDatabaseConnection();
        $placesStmt = $pdo->query("SELECT id_Vieta, Miestas_Kaimas, Gatve FROM vietos");
        $places = $placesStmt->fetchAll(PDO::FETCH_ASSOC);

        $eradicatorsStmt = $pdo->query("SELECT id_Naudotojas, Vardas, Pavarde, El_pastas FROM naudotojai WHERE tipas = 'Naikintojas'");
        $eradicators = $eradicatorsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Load the form view
        include '../views/assign-permits.php';
    }

    public function processAssignPermit()
    {
        // Check if user is admin
        if ($_SESSION['role'] != 'Administratorius') {
            header("Location: index.php?page=unauthorized");
            exit();
        }

        // Retrieve selected places and eradicators
        $selectedPlaces = $_POST['places'] ?? [];
        $selectedEradicators = $_POST['eradicators'] ?? [];

        // Validate selections
        if (empty($selectedPlaces) || empty($selectedEradicators)) {
            $_SESSION['alert_message'] = "Prašome pasirinkti bent vieną naikintoją ir bent vieną vietą!";
            $_SESSION['alert_type'] = "error";
            header("Location: index.php?page=assign-permits");
            exit();
            return;
        }

        $pdo = getDatabaseConnection();
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM leidimai WHERE fk_Administratorius = :admin_id AND fk_Naikintojas = :eradicator_id AND fk_Vieta = :place_id");
        $insertStmt = $pdo->prepare("INSERT INTO leidimai (Data, fk_Administratorius, fk_Naikintojas, fk_Vieta) VALUES (NOW(), :admin_id, :eradicator_id, :place_id)");

        $c = 0;

        foreach ($selectedPlaces as $placeId) {
            foreach ($selectedEradicators as $eradicatorId) {
                // Check if the permit already exists
                $checkStmt->execute([
                    'admin_id' => $_SESSION['user_id'],
                    'eradicator_id' => $eradicatorId,
                    'place_id' => $placeId
                ]);

                if ($checkStmt->fetchColumn() == 0) {
                    // Insert the new permit
                    $insertStmt->execute([
                        'admin_id' => $_SESSION['user_id'],
                        'eradicator_id' => $eradicatorId,
                        'place_id' => $placeId
                    ]);
                    $c += 1;
                }
            }
        }

        if ($c == 0) {
            $_SESSION['alert_message'] = "Nebuvo sukurta naikinimo leidimų.";
            $_SESSION['alert_type'] = "error";
            header("Location: index.php?page=view-permits");
            exit();
        } elseif ($c == 1) {
            $_SESSION['alert_message'] = "Naikinimo leidimas sukurtas sėkmingai!";
        }else {
            $_SESSION['alert_message'] = "Naikinimo leidimai sukurti sėkmingai!";
        }
        
        $_SESSION['alert_type'] = "success";

        header("Location: index.php?page=view-permits");
        exit();
    }

    public function viewAssignedPermits()
    {
        // Check if user is admin
        if ($_SESSION['role'] == 'Paprastas') {
            header("Location: index.php?page=unauthorized");
            exit();
        }
        //print_r($_SESSION);
        $userId = $_SESSION['user_id'];

        // Fetch permits from the database
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("
                SELECT 
                    leidimai.id_Leidimas AS permit_id,
                    leidimai.Data AS date,
                    apskritys.Pavadinimas AS region,
                    savivaldybes.Pavadinimas AS municipality,
                    vietos.Miestas_Kaimas AS city,
                    vietos.Gatve AS street,
                    vietos.Plotas AS area,
                    vietos.Nuotrauka AS photoPath,
                    koordinates.Platuma AS latitude,
                    koordinates.Ilguma AS longitude

                FROM leidimai
                JOIN vietos ON leidimai.fk_Vieta = vietos.id_Vieta
                JOIN apskritys ON vietos.fk_Apskritis = apskritys.id_Apskritis
                JOIN savivaldybes ON vietos.fk_Savivaldybe = savivaldybes.id_Savivaldybe
                LEFT JOIN koordinates ON vietos.fk_Koordinate = koordinates.id_Koordinate

                WHERE leidimai.Sunaikinimo_data IS NULL AND leidimai.fk_Naikintojas = $userId;
            ");
        $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Load the view to display permits
        include '../views/view-assigned-permits.php';
    }

    public function loadEradicationForm() {
        // Check if the user is authorized
        if ($_SESSION['role'] != 'Naikintojas') {
            header("Location: index.php?page=unauthorized");
            exit();
        }
    
        // Get permit ID from request
        $permitId = $_GET['id'] ?? null;
        if (!$permitId) {
            header("Location: index.php?page=404");
            exit();
        }
    
        // Fetch permit details from the database
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("
            SELECT 
                leidimai.id_Leidimas AS permit_id,
                leidimai.Data AS date,
                apskritys.Pavadinimas AS region,
                savivaldybes.Pavadinimas AS municipality,
                vietos.id_Vieta AS place_id,
                vietos.Miestas_Kaimas AS city,
                vietos.Gatve AS street,
                vietos.Plotas AS area,
                koordinates.Platuma AS latitude,
                koordinates.Ilguma AS longitude
            FROM leidimai
            JOIN vietos ON leidimai.fk_Vieta = vietos.id_Vieta
            JOIN apskritys ON vietos.fk_Apskritis = apskritys.id_Apskritis
            JOIN savivaldybes ON vietos.fk_Savivaldybe = savivaldybes.id_Savivaldybe
            LEFT JOIN koordinates ON vietos.fk_Koordinate = koordinates.id_Koordinate
            WHERE leidimai.id_Leidimas = :permitId
        ");
        $stmt->bindParam(':permitId', $permitId, PDO::PARAM_INT);
        $stmt->execute();
    
        $permit = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$permit) {
            header("Location: index.php?page=error&message=Permit Not Found");
            exit();
        }
    
        // Load the eradication form view
        include '../views/complete-eradication.php';
    }


    public function processEradicationForm() {
        // Check if the user is authorized
        if ($_SESSION['role'] != 'Naikintojas') {
            header("Location: index.php?page=unauthorized");
            exit();
        }
    
        // Get permit ID and eradication data from request
        $permitId = $_POST['permit_id'] ?? null;
        $placeId = $_POST['place_id'] ?? null;
        $eradicationDate = $_POST['eradication_date'] ?? null;
        $useCurrentDate = isset($_POST['use_current_date']);
    
        // Validate the permit ID
        if (!$permitId) {
            header("Location: index.php?page=error&message=Invalid Permit ID");
            exit();
        }
    
        // Set eradication date
        if ($useCurrentDate) {
            $eradicationDate = date('Y-m-d');
        } elseif (!$eradicationDate) {
            header("Location: index.php?page=error&message=Eradication Date Required");
            exit();
        }
    
        // Update the database with the eradication date
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("
            UPDATE leidimai
            SET Sunaikinimo_data = :eradicationDate
            WHERE id_Leidimas = :permitId AND fk_Naikintojas = :eradicatorId;

            UPDATE vietos 
            SET Naikinimo_data = :eradicationDate
            WHERE id_Vieta = :placeId;
        ");
        $stmt->bindParam(':eradicationDate', $eradicationDate);
        $stmt->bindParam(':permitId', $permitId, PDO::PARAM_INT);
        $stmt->bindParam(':eradicatorId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':placeId', $placeId, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $_SESSION['alert_message'] = "Naikinimo atlikimas įrašytas!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['alert_message'] = "Įvyko klaida įrašant naikinimo atlikimą. Prašome bandyti dar kartą.";
            $_SESSION['alert_type'] = "error";
        }
        
        header("Location: index.php?page=view-assigned-permits");
        exit();
    }
    
    
}
