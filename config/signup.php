<?php
// Start session
session_start();

// Include database connection
require '../database/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['sEmail']);
    $password = trim($_POST['sPassword']);

    // Generate UID by hashing email with MD5
    $uid = md5($email);

    // Hash the password (using MD5 for compatibility as requested)
    $hashed_password = md5($password);

    // Prepare a SQL statement to retrieve the user
    $checkValidation = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $checkValidation->bindParam(':email', $email);
    $checkValidation->execute();

    // Fetch the user data
    $user = $checkValidation->fetch();

    if (!$user) {
        try {
            // Prepare the INSERT statement with default values for phone_number (NULL) and is_owner (FALSE)
            $stmt = $pdo->prepare("INSERT INTO users (uid, full_name, email, password, phone, is_owner) 
                                   VALUES (:uid, :full_name, :email, :password, NULL, FALSE)");
            $stmt->bindParam(':uid', $uid);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                $_SESSION['login'] = true;
                $_SESSION['uid'] = $uid;
                header("Location: ../");
                exit;
            } else {
                echo "Error: Unable to register user.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Account Already Exist'); 
            location = '../';
        </script>
        ";
    }
}