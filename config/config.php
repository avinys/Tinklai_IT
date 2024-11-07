<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tinklaiit');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', 'http://localhost/projektas'); // PAKEISTI PRIES LEIDZIANT VM

ini_set('display_errors', 1);
error_reporting(E_ALL);

function getDatabaseConnection() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}
