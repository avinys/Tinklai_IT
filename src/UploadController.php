<?php
require_once '../config/config.php';
require_once '../src/helpers.php';

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
            $uploadDir = '../uploads/';
            $photoPath = $uploadDir . basename($photo['name']);
            move_uploaded_file($photo['tmp_name'], $photoPath);

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

            // Insert location data into the 'vieta' table
            $stmt = $pdo->prepare("INSERT INTO vietos (Miestas_Kaimas, Gatve, Plotas, fk_Apskritis, fk_Savivaldybe, fk_Koordinate, fk_Savininkas, Sunaikinta, Kurimo_data) 
                                   VALUES (:city, :street, :area, :region, :municipality, :coordinate, :owner, 0, NOW())");
            $stmt->execute([
                'city' => $city,
                'street' => $street,
                'area' => $area,
                'region' => $region,
                'municipality' => $municipality,
                'coordinate' => $coordinateId,
                'owner' => $_SESSION['user_id']
            ]);

            header('Location: index.php?page=home');
            exit();
        }
    }

    private function getCoordinatesFromMetadata($photoPath)
    {
        if (!function_exists('exif_read_data')) {
            return null;
        }

        $exif = exif_read_data($photoPath);
        if ($exif && isset($exif['GPSLatitude'], $exif['GPSLongitude'])) {
            $latitude = $this->convertGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']);
            $longitude = $this->convertGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']);
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
            $stmt = $pdo->prepare("SELECT * FROM vietos");
            $stmt->execute();
        } elseif ($userRole === 'Naikintojas') {
            // Destroyer can see own uploads and those assigned to them
            $stmt = $pdo->prepare("
            SELECT v.*
            FROM vietos v
            LEFT JOIN leidimai l ON v.id_Vieta = l.fk_Vieta
            WHERE v.fk_Savininkas = :userId OR l.fk_Naikintojas = :userId
        ");
            $stmt->execute(['userId' => $userId]);
        } else {
            // Regular users can only see their own uploads
            $stmt = $pdo->prepare("SELECT * FROM vietos WHERE fk_Savininkas = :userId");
            $stmt->execute(['userId' => $userId]);
        }

        $uploads = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        // Fetch regions and municipalities for dropdowns
        $regionsStmt = $pdo->query("SELECT id_Apskritis AS id, Pavadinimas AS name FROM apskritys");
        $regions = $regionsStmt->fetchAll(PDO::FETCH_ASSOC);

        $municipalitiesStmt = $pdo->query("SELECT id_Savivaldybe AS id, Pavadinimas AS name FROM savivaldybes");
        $municipalities = $municipalitiesStmt->fetchAll(PDO::FETCH_ASSOC);

        include '../views/edit-upload.php';
    }

    public function processEdit($uploadId)
    {
        $pdo = getDatabaseConnection();

        // Handle file upload if a new file is provided
        $photoPath = null;
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo'];
            $uploadDir = '../uploads/';
            $photoPath = $uploadDir . basename($photo['name']);
            move_uploaded_file($photo['tmp_name'], $photoPath);
        }

        // Prepare the data to update
        $data = [
            'village' => sanitize($_POST['village']),
            'street' => sanitize($_POST['street']),
            'area' => (int)$_POST['area'],
            'region' => (int)$_POST['region'],
            'municipality' => (int)$_POST['municipality'],
            'id' => $uploadId
        ];

        // Update query with photo if updated
        if ($photoPath) {
            $data['photo'] = $photoPath;
            $stmt = $pdo->prepare("UPDATE vietos SET Miestas = :village, Gatve = :street, Plotas = :area, fk_Apskritis = :region, fk_Savivaldybe = :municipality, photo = :photo WHERE id_Vieta = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE vietos SET Miestas = :village, Gatve = :street, Plotas = :area, fk_Apskritis = :region, fk_Savivaldybe = :municipality WHERE id_Vieta = :id");
        }

        $stmt->execute($data);

        header("Location: index.php?page=view-uploads");
        exit();
    }
}
