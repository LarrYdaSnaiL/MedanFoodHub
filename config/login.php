<?php
// Start session
session_start();

// Include database connection
require '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a SQL statement to retrieve the user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch();

    // Check if user exists and password matches using MD5
    if ($user && $user['password'] === md5($password)) {
        // Password matches, set session variables
        $_SESSION['login'] = true;
        $_SESSION['uid'] = $user['uid'];

        // Redirect to the dashboard or homepage
        header("Location: ../");
        exit;
    } else {
        // Invalid credentials, redirect back to login page with error
        echo "<script>
        alert('Invalid Credentials');
        window.location.href = '../';
        </script>";
        exit;
    }
}
