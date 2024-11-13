<?php
require_once '../config/config.php';
require_once '../src/helpers.php';

class AuthController
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $surname = sanitize($_POST['surname']);
            $email = sanitize($_POST['email']);
            $password = sanitize($_POST['password']);
            $isDestroyer = isset($_POST['destroy']) ? 1 : 0;

            // Determine user type
            $userType = $isDestroyer ? 'Naikintojas' : 'Paprastas';

            // Check if user already exists
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT * FROM Naudotojai WHERE El_pastas = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->rowCount() > 0) {
                $_SESSION['alert_message'] = "Paskyra su tokiu el. paštu jau egzistuoja.";
                $_SESSION['alert_type'] = "error";
                header("Location: index.php?page=register");
                exit;
            }

            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $stmt = $pdo->prepare("INSERT INTO naudotojai (Vardas, Pavarde, El_pastas, Slaptazodis, Tipas) VALUES (:name, :surname, :email, :password, :type)");
            if ($stmt->execute(['name' => $name, 'surname' => $surname, 'email' => $email, 'password' => $hashedPassword, 'type' => $userType])) {
                $_SESSION['alert_message'] = "Registracija sėkminga!";
                $_SESSION['alert_type'] = "success";
                header("Location: index.php?page=login");
                exit;
            } else {
                $_SESSION['alert_message'] = "Įvyko klaida. Prašome bandyti dar kartą.";
                $_SESSION['alert_type'] = "error";
                header("Location: index.php?page=register");
                exit;
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email']);
            $password = sanitize($_POST['password']);

            // Retrieve user data from the database
            $pdo = getDatabaseConnection();
            $stmt = $pdo->prepare("SELECT * FROM naudotojai WHERE El_pastas = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Slaptazodis'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id_Naudotojas'];
                $_SESSION['username'] = $user['Vardas'];
                $_SESSION['role'] = $user['Tipas'];

                // Redirect to a secure page or dashboard
                header('Location: index.php?page=home');
                exit();
            } else {
                echo "<script>
                        alert('Neteisingas el. paštas arba slaptažodis.');
                        window.location.href = 'index.php?page=login';
                      </script>";
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?page=home");
        exit();
    }
}
