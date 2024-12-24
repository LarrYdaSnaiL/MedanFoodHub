<?php
session_start();

include '../database/connection.php';
include 'phpmailer.php';

if (isset($_GET['verify'])) {
    $verificationCode = $_GET['verify'];

    $sql = "SELECT * FROM verification_code WHERE verification_code = :verificationCode AND is_used = false";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':verificationCode', $verificationCode);
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        $sql = "UPDATE verification_code SET is_used = true WHERE verification_code = :verificationCode";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':verificationCode', $verificationCode);
        $stmt->execute();

        $sql = "UPDATE users SET is_verified = true WHERE uid = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':uid', $result['uid']);
        $stmt->execute();

        echo "
        <script>
            alert('Verification Success');
            window.location.href = '/public/account';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Invalid verification code.');
            window.location.href = '/public/account';
        </script>
        ";
    }
}