<?php
require_once '../config/config.php';
require_once '../src/helpers.php';
require '../vendor/autoload.php';

use Dotenv\Dotenv;

class UploadController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function populateUploadForm()
    {
        $pdo = getDatabaseConnection();

        $regionsStmt = $pdo->query("SELECT id_Apskritis AS id, Pavadinimas AS name FROM apskritys");
        $regions = $regionsStmt->fetchAll(PDO::FETCH_ASSOC);

        $municipalitiesStmt = $pdo->query("SELECT id_Savivaldybe AS id, Pavadinimas AS name FROM savivaldybes");
        $municipalities = $municipalitiesStmt->fetchAll(PDO::FETCH_ASSOC);

        include '../views/upload.php';
    }

    public function fetchMunicipalities()
    {
        $regionId = isset($_GET['region']) ? intval($_GET['region']) : 0;

        if ($regionId > 0) {
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT id_Savivaldybe AS id, Pavadinimas AS name FROM savivaldybes WHERE fk_Apskritis = :regionId");
            $stmt->execute(['regionId' => $regionId]);
            $municipalities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($municipalities);
        } else {
            echo json_encode([]);
        }
        exit();
    }


    public function processUpload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
            $pdo = getDatabaseConnection();

            // File upload
            $photo = $_FILES['photo'];
            $uploadDir = '../public/uploads/';
            $photoPath = "/uploads/" . basename($photo['name']);
            move_uploaded_file($photo['tmp_name'], $uploadDir . basename($photo['name']));
            $_SESSION['alert_message'] = $uploadDir . basename($photo['name']);
            $_SESSION['alert_type'] = "success";
            print_r($photoPath);

            // Extract metadata (coordinates) if available
            $coordinates = $this->getCoordinatesFromMetadata($photoPath);

            // Gather location info
            $region = $_POST['region'];
            $municipality = $_POST['municipality'];
            $city = sanitize($_POST['city']);
            $street = sanitize($_POST['street']);
            $area = sanitize($_POST['area']);
            $latitude = $coordinates['latitude'] ?? null;
            $longitude = $coordinates['longitude'] ?? null;

            // Insert coordinate data if available
            $coordinateId = null;
            if ($latitude && $longitude) {
                $coordinateStmt = $pdo->prepare("INSERT INTO koordinates (Platuma, Ilguma) VALUES (:latitude, :longitude)");
                $coordinateStmt->execute(['latitude' => $latitude, 'longitude' => $longitude]);
                $coordinateId = $pdo->lastInsertId();
            }

            // Insert location data into the 'vieta' table, including the photo path
            $stmt = $pdo->prepare("INSERT INTO vietos (Miestas_Kaimas, Gatve, Plotas, fk_Apskritis, fk_Savivaldybe, fk_Koordinate, fk_Savininkas, Sunaikinta, Kurimo_data, Nuotrauka) 
                                   VALUES (:city, :street, :area, :region, :municipality, :coordinate, :owner, 0, NOW(), :photoPath)");

            if ($stmt->execute([
                'city' => $city,
                'street' => $street,
                'area' => $area,
                'region' => $region,
                'municipality' => $municipality,
                'coordinate' => $coordinateId,
                'owner' => $_SESSION['user_id'],
                'photoPath' => $photoPath
            ])) {
                $_SESSION['alert_message'] = $_SESSION['alert_message'] . "Vieta pažymėta sėkmingai!";
                $_SESSION['alert_type'] = "success";
                header("Location: index.php?page=view-uploads");
                exit;
            } else {
                $_SESSION['alert_message'] = "Įvyko klaida. Prašome bandyti dar kartą.";
                $_SESSION['alert_type'] = "error";
                header("Location: index.php?page=view-uploads");
                exit;
            }
        }
    }


    private function getCoordinatesFromMetadata($photoPath)
    {
        if (!function_exists('exif_read_data')) {
            $_SESSION['alert_message'] = "Nerandama funkcija!";
            $_SESSION['alert_type'] = "error";
            // header("Location: index.php?page=view-uploads");
            // exit;
            return null;
        }

        $exif = exif_read_data("../public" . $photoPath);

        if (!isset($exif['GPSLatitude'], $exif['GPSLongitude']) || !$exif) {
            $_SESSION['alert_message'] = "Nerandami metaduomenu!";
            $_SESSION['alert_type'] = "error";
            // header("Location: index.php?page=home");
        }

        if ($exif && isset($exif['GPSLatitude'], $exif['GPSLongitude'])) {
            $latitude = $this->convertGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
            $longitude = $this->convertGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
            $_SESSION['alert_message'] = "Iš metaduomenų ištrauktos koordinates: " . $latitude . ", " . $longitude . ".\n";
            $_SESSION['alert_type'] = "error";
            // header("Location: index.php?page=home");
            // exit;
            return ['latitude' => $latitude, 'longitude' => $longitude];
        }

        return null;
    }

    private function convertGps($coordinate, $hemisphere)
    {
        $degrees = count($coordinate) > 0 ? $this->convertGpsValue($coordinate[0]) : 0;
        $minutes = count($coordinate) > 1 ? $this->convertGpsValue($coordinate[1]) : 0;
        $seconds = count($coordinate) > 2 ? $this->convertGpsValue($coordinate[2]) : 0;

        $flip = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        return $flip * ($degrees + ($minutes / 60) + ($seconds / 3600));
    }

    private function convertGpsValue($coordinatePart)
    {
        $parts = explode('/', $coordinatePart);
        if (count($parts) <= 0) return 0;
        if (count($parts) == 1) return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }

    public function viewUploads()
    {
        $pdo = getDatabaseConnection();

        // Get user info from session
        $userId = $_SESSION['user_id'];
        $userRole = $_SESSION['role'];

        // Prepare SQL based on user role
        if ($userRole === 'Administratorius') {
            // Admin can see all uploads
            $stmt = $pdo->prepare("
            SELECT DISTINCT v.*,
            apskritys.Pavadinimas AS apskritis,
            savivaldybes.Pavadinimas AS savivaldybe,
            koordinates.Platuma AS platuma,
            koordinates.Ilguma AS ilguma
            FROM vietos v
            LEFT JOIN leidimai l ON v.id_Vieta = l.fk_Vieta
            JOIN savivaldybes ON v.fk_Savivaldybe = savivaldybes.id_Savivaldybe
            JOIN apskritys ON v.fk_Apskritis = apskritys.id_Apskritis
            LEFT JOIN koordinates ON v.fk_Koordinate = koordinates.id_Koordinate
        ");
            $stmt->execute();
        } elseif ($userRole === 'Naikintojas') {
            // Destroyer can see own uploads and those assigned to them
            $stmt = $pdo->prepare("
            SELECT DISTINCT v.*,
            apskritys.Pavadinimas AS apskritis,
            savivaldybes.Pavadinimas AS savivaldybe,
            koordinates.Platuma AS platuma,
            koordinates.Ilguma AS ilguma
            FROM vietos v
            LEFT JOIN leidimai l ON v.id_Vieta = l.fk_Vieta
            JOIN savivaldybes ON v.fk_Savivaldybe = savivaldybes.id_Savivaldybe
            JOIN apskritys ON v.fk_Apskritis = apskritys.id_Apskritis
            LEFT JOIN koordinates ON v.fk_Koordinate = koordinates.id_Koordinate
            WHERE v.fk_Savininkas = :userId OR l.fk_Naikintojas = :userId
        ");
            $stmt->execute(['userId' => $userId]);
        } else {
            // Regular users can only see their own uploads
            $stmt = $pdo->prepare("
            SELECT DISTINCT v.*,
            v.Nuotrauka AS Nuotrauka,
            apskritys.Pavadinimas AS apskritis,
            savivaldybes.Pavadinimas AS savivaldybe,
            koordinates.Platuma AS platuma,
            koordinates.Ilguma AS ilguma
            FROM vietos v
            LEFT JOIN leidimai l ON v.id_Vieta = l.fk_Vieta
            JOIN savivaldybes ON v.fk_Savivaldybe = savivaldybes.id_Savivaldybe
            JOIN apskritys ON v.fk_Apskritis = apskritys.id_Apskritis
            LEFT JOIN koordinates ON v.fk_Koordinate = koordinates.id_Koordinate
            WHERE v.fk_Savininkas = :userId
        ");
            $stmt->execute(['userId' => $userId]);
        }

        $uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($uploads as &$upload) {
            $upload['owner'] = ($upload['fk_Savininkas'] == $_SESSION['user_id']) || $_SESSION['role'] == "Administratorius";
        }

        // Unset the reference to avoid potential issues
        unset($upload);
        include '../views/view-uploads.php';
    }
    public function showEditForm($uploadId)
    {
        $pdo = getDatabaseConnection();

        // Fetch the upload data
        $stmt = $pdo->prepare("SELECT * FROM vietos WHERE id_Vieta = :id");
        $stmt->execute(['id' => $uploadId]);
        $upload = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if upload exists and if the user has permission
        if (!$upload) {
            die("Įrašas nerastas");
        }

        // Fetch regions for dropdown
        $regionsStmt = $pdo->query("SELECT id_Apskritis AS id, Pavadinimas AS name FROM apskritys");
        $regions = $regionsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch municipalities based on the selected region
        $selectedRegionId = $upload['fk_Apskritis'];
        $municipalitiesStmt = $pdo->prepare("SELECT id_Savivaldybe AS id, Pavadinimas AS name FROM savivaldybes WHERE fk_Apskritis = :region_id");
        $municipalitiesStmt->execute(['region_id' => $selectedRegionId]);
        $municipalities = $municipalitiesStmt->fetchAll(PDO::FETCH_ASSOC);

        include '../views/edit-upload.php';
    }

    public function processEdit($uploadId)
    {
        $pdo = getDatabaseConnection();

        // Fetch the existing photo path from the database
        $stmt = $pdo->prepare("SELECT Nuotrauka FROM vietos WHERE id_Vieta = :id");
        $stmt->execute(['id' => $uploadId]);
        $existingPhoto = $stmt->fetchColumn();

        // Handle file upload if a new file is provided
        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo'];
            $uploadDir = '../public/uploads/';
            $photoPath = "/uploads/" . basename($photo['name']); // Corrected path format

            // Remove the existing photo file if it exists
            if ($existingPhoto && file_exists("../public" . $existingPhoto)) {
                unlink("../public" . $existingPhoto);
            }

            // Move the new uploaded file to the uploads directory
            move_uploaded_file($photo['tmp_name'], $uploadDir . basename($photo['name']));
        }

        // Prepare the data to update
        $data = [
            'city' => sanitize($_POST['city']),
            'street' => sanitize($_POST['street']),
            'area' => (int)$_POST['area'],
            'region' => (int)$_POST['region'],
            'municipality' => (int)$_POST['municipality'],
            'id' => $uploadId
        ];

        // Update query with photo if updated
        if ($photoPath) {
            $data['photo'] = $photoPath;
            $stmt = $pdo->prepare("UPDATE vietos SET Miestas_Kaimas = :city, Gatve = :street, Plotas = :area, fk_Apskritis = :region, fk_Savivaldybe = :municipality, Nuotrauka = :photo WHERE id_Vieta = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE vietos SET Miestas_Kaimas = :city, Gatve = :street, Plotas = :area, fk_Apskritis = :region, fk_Savivaldybe = :municipality WHERE id_Vieta = :id");
        }

        if ($stmt->execute($data)) {
            $_SESSION['alert_message'] = "Vieta redaguota sėkmingai!";
            $_SESSION['alert_type'] = "success";
            header("Location: index.php?page=view-uploads");
            exit;
        } else {
            $_SESSION['alert_message'] = "Įvyko klaida. Prašome bandyti dar kartą.";
            $_SESSION['alert_type'] = "error";
            header("Location: index.php?page=view-uploads");
            exit;
        }
    }

    public function deleteUpload($uploadId)
    {
        $pdo = getDatabaseConnection();

        // Retrieve the file path from the database
        $stmt = $pdo->prepare("SELECT Nuotrauka FROM vietos WHERE id_Vieta = :id");
        $stmt->execute(['id' => $uploadId]);
        $photoPath = $stmt->fetchColumn();

        if ($photoPath) {
            // Construct the full file path on the server
            $fullPath = __DIR__ . '/../public' . $photoPath;

            // Check if the file exists and delete it
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        // Delete the database record
        $stmt = $pdo->prepare("DELETE FROM vietos WHERE id_Vieta = :id");
        if ($stmt->execute(['id' => $uploadId])) {
            $_SESSION['alert_message'] = "Įrašas sėkmingai ištrintas!";
            $_SESSION['alert_type'] = "success";
        } else {
            $_SESSION['alert_message'] = "Įvyko klaida trinant įrašą. Prašome bandyti dar kartą.";
            $_SESSION['alert_type'] = "error";
        }

        // Redirect back to the uploads view page
        header("Location: index.php?page=view-uploads");
        exit;
    }

    public function viewMap($uploadId, $from)
    {    
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $apiKey = $_ENV['GOOGLEMAPS_API_KEY'];
        //print_r($apiKey);
        $pdo = getDatabaseConnection();

        if (!$apiKey) {
            $_SESSION['alert_message'] =  "Nerastas API raktas!";
            $_SESSION['alert_type'] = "error";
            header("Location: index.php?page=$from");
            exit;
        }

        $stmt = $pdo->prepare("SELECT vietos.*, k.Ilguma AS ilguma, k.Platuma AS platuma FROM vietos 
                               LEFT JOIN koordinates AS k ON vietos.fk_Koordinate = k.id_Koordinate
                               WHERE id_Vieta = :id ");
        
        $stmt->execute(['id' => $uploadId]);
        $upload = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!isset($upload['ilguma']) || !isset($upload['platuma'])) {
            $_SESSION['alert_message'] =  "Nerastos vietos koordinates!";
            $_SESSION['alert_type'] = "error";
            header("Location: index.php?page=$from");
            exit;
        }

        

        include '../views/view-map.php';
        exit;
    }
}
