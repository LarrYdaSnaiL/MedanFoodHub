<?php
require '../vendor/autoload.php';
use Cloudinary\Configuration\Configuration;

// Correct the path to your .env file
$envFilePath = __DIR__ . '/../.env';

if (!file_exists($envFilePath)) {
    die("Error: .env file not found.");
}

$env = parse_ini_file($envFilePath);

if ($env === false) {
    die("Error: Unable to parse .env file.");
}

// Access environment variables
$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$user = $env['DB_USER'];
$password = $env['DB_PASS'];
$port = $env['DB_PORT'];

$cloud_name = $env['CLOUDINARY_CLOUD_NAME'];
$cloud_api_key = $env['CLOUDINARY_API_KEY'];
$cloud_api_secret = $env['CLOUDINARY_SECRET_KEY'];

Configuration::instance([
    'cloud' => [
        'cloud_name' => $cloud_name,
        'api_key' => $cloud_api_key,
        'api_secret' => $cloud_api_secret,
    ],
    'url' => [
        'secure' => true
    ]
]);

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

} catch (PDOException $e) {
    exit;
}