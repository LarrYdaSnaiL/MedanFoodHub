<?php
try {
    // Start session and database connection
    session_start();
    require '../database/connection.php';

    if (!isset($_SESSION['login'])) {
        header("Location: ../");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_email'])) {
        $confirm_email = $_POST['confirm_email'];
        $hashed_email = md5($confirm_email);

        // Start database transaction
        $pdo->beginTransaction();

        // Verify if the hashed email exists in the database
        $stmt = $pdo->prepare("SELECT uid FROM users WHERE uid = :uid");
        $stmt->bindParam(':uid', $hashed_email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $uid = $hashed_email;

            try {
                // Delete related user-related entries first
                $tablesToDelete = ['reviews', 'restaurants', 'businessowner', 'verification_code'];
                foreach ($tablesToDelete as $table) {
                    $stmt = $pdo->prepare("DELETE FROM $table WHERE uid = :uid");
                    $stmt->bindParam(':uid', $uid);
                    $stmt->execute();
                }

                // Delete the user from the primary table
                $stmt = $pdo->prepare("DELETE FROM users WHERE uid = :uid");
                $stmt->bindParam(':uid', $uid);
                $stmt->execute();

                // Commit the transaction after successful deletions
                $pdo->commit();

                // Destroy session and redirect to home
                session_destroy();
                header("Location: ../");
                exit();
            } catch (Exception $e) {
                // Rollback if deletion fails
                $pdo->rollBack();
                echo "<script>alert('Error while deleting user-related data.'); window.history.back();</script>";
            }
        } else {
            $pdo->rollBack();
            echo "<script>alert('The provided email does not match our records.'); window.history.back();</script>";
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>