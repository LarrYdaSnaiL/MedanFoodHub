<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Correct the path to your .env file
$envFilePath = __DIR__ . '/../.env';

if (!file_exists($envFilePath)) {
    die("Error: .env file not found.");
}

$env = parse_ini_file($envFilePath);

if ($env === false) {
    die("Error: Unable to parse .env file.");
}

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'medanfoodhub@gmail.com';
    $mail->Password = "{$env['APP_PASSWORD']}";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $env['APP_PORT'];

    $mail->setFrom('medanfoodhub@gmail.com', 'MedanFoodHub');
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}