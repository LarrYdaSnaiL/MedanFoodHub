<?php
// Start session
session_start();

// Include database connection
require '../database/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: ../");
    exit();
}

// Get user input
$confirm_email = $_POST['confirm_email'];

// Hash the provided email to match the uid in the database
$hashed_email = md5($confirm_email);

// Query to check if the hashed email matches the user's stored uid
try {
    $sql = "SELECT uid FROM users WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $hashed_email);
    $stmt->execute();

    // Verify if the email hash matches
    if ($stmt->rowCount() === 1) {
        // Delete user-related data from other tables
        $uid = $hashed_email;

        // Begin transaction
        $pdo->beginTransaction();
        $pdo->prepare("DELETE FROM users WHERE uid = :uid")->execute([':uid' => $uid]);

        // Commit transaction
        $pdo->commit();

        // Log out and redirect
        session_destroy();
        header("Location: ../index.php?message=Account deleted successfully");
        exit();
    } else {
        // Email does not match
        echo "<script>alert('The provided email does not match our records.'); window.history.back();</script>";
    }
} catch (Exception $e) {
    // Rollback in case of error
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}