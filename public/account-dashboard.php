<?php
include "../database/connection.php";
session_start();

use Cloudinary\Api\Upload\UploadApi;

// Check if the user is logged in
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header("Location: ../");
    exit();
}

try {
    $sql = "SELECT * FROM users WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $full_name = $user['full_name'];
        $profilePic = $user['profile_pic'];
        $email = $user['email'];
        $phone = $user['phone'];
        $bio = $user['bio'];
        $is_admin = $user['is_admin'];

        $sql = "SELECT * FROM businessowner WHERE uid = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':uid', $_SESSION['uid']);

        if ($stmt->execute()) {
            $owner = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($owner) {
                if ($owner['status'] === 'approved') {
                    $is_owner = true;
                } else {
                    $is_owner = false;
                }
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard - MedanFoodHub</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.0/dist/tesseract.min.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="/"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Home</a>
                    <?php
                    if ($is_admin) {
                        echo "
                        <a href='admin'
                            class='block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg'>Admin Dashboard</a>
                        ";
                    }
                    ?>
                    <a href="#verifyAccount"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg <?php echo !$is_admin ? ($is_owner ? 'hidden' : '') : 'hidden'; ?>">
                        Verify Account
                    </a>
                    <a href="business"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg <?php echo !$is_admin ? ($is_owner ? '' : 'hidden') : 'hidden'; ?>">
                        Your Business
                    </a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">
                        Log Out
                    </a>
                    <a id="deleteAccount" href="#"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg text-red-600">
                        Delete Account
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Delete Account Modal -->
        <div id="deleteAccountModal"
            class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-8 w-96">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Confirm Account Deletion</h2>
                <p class="text-sm text-gray-600 mb-6 text-center">Please re-enter your email to confirm account
                    deletion.</p>

                <form id="deleteAccountForm" method="POST" action="../config/delete_account.php">
                    <label for="confirmEmail" class="block text-gray-700">Email</label>
                    <input type="email" id="confirmEmail" name="confirm_email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                        placeholder="example@gmail.com">

                    <button type="submit"
                        class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition duration-200">Delete
                        Account</button>
                </form>

                <div class="flex justify-center mt-4">
                    <button id="closeDeleteModal" class="text-gray-600 hover:text-gray-900">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <section id="profileSettings" class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Profile Settings</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <img src="<?php echo $profilePic != null ? $profilePic : './assets/blankPic.png' ?>"
                            alt="Current Profile Picture" id="profilePic"
                            class="w-32 h-32 rounded-full mx-auto object-cover mb-3">
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/*"
                            class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="mb-4">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">Name</label>
                        <input type="text" id="full_name" name="full_name"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="New Name..." value="<?php echo htmlspecialchars($full_name); ?>">
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="Write something about yourself..."><?php echo htmlspecialchars($bio != null ? $bio : ''); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="example@gmail.com" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        <?php
                        if (!$user['is_verified']) { ?>
                            <button type="submit" name="verify_email"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200 mt-2">
                                Verify Email
                            </button>
                        <?php }
                        ?>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="Phone Number"
                            value="<?php echo htmlspecialchars($phone != null ? $phone : ''); ?>">
                    </div>

                    <button type="submit" name="save_changes"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200">Save
                        Changes</button>
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['save_changes'])) {
                        $full_name = trim($_POST['full_name']);
                        $bio = $_POST['bio'];
                        $email = trim($_POST['email']);
                        $phone = $_POST['phone'];
                        $uid = md5($email);
                        $downloadUrl = $profilePic;
                        try {
                            if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
                                $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
                                $fileName = $_FILES['profilePicture'][$full_name];

                                try {
                                    $upload = new UploadApi();
                                    $result = $upload->upload($fileTmpPath, [
                                        "folder" => "MedanFoodHub/Profile Picture/",
                                        "public_id" => $uid
                                    ]);

                                    $downloadUrl = $result['secure_url'];

                                } catch (Exception $e) {
                                    echo 'Upload Error: ' . $e->getMessage();
                                }
                            }

                            if ($uid == $_SESSION['uid']) {
                                $stmt = $pdo->prepare("UPDATE users SET full_name = :full_name, bio = :bio, email = :email, phone = :phone, profile_pic = :profile_pic WHERE uid = :uid");
                            } else {
                                // Prepare a SQL statement to retrieve the user
                                $checkValidation = $pdo->prepare("SELECT * FROM users WHERE uid = :uid");
                                $checkValidation->bindParam(':uid', $uid);
                                $checkValidation->execute();

                                // Fetch the user data
                                $user = $checkValidation->fetch();

                                if (!$user) {
                                    $upload = new UploadApi();
                                    $result = $upload->rename(
                                        "MedanFoodHub/Profile Picture/" . $_SESSION['uid'],
                                        "MedanFoodHub/Profile Picture/" . $uid
                                    );

                                    $downloadUrl = $result["secure_url"];

                                    $stmt = $pdo->prepare("UPDATE users SET uid = :new_uid, full_name = :full_name, bio = :bio, email = :email, phone = :phone, profile_pic = :profile_pic WHERE uid = :uid");
                                    $stmt->bindParam(':new_uid', $uid);
                                } else {
                                    echo "
                                        <script>
                                            alert('Email Exists');
                                            window.location.href = './account';
                                        </script>
                                        ";
                                }
                            }

                            $stmt->bindParam(':full_name', $full_name);
                            $stmt->bindParam(':bio', $bio);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':phone', $phone);
                            $stmt->bindParam(':profile_pic', $downloadUrl);
                            $stmt->bindParam(':uid', $_SESSION['uid']);

                            if ($stmt->execute()) {
                                $_SESSION['uid'] = $uid;
                                echo "<script> window.location.href = './account';</script>";
                            } else {
                                echo "<script>alert('Failed to update profile.');</script>";
                            }
                        } catch (Exception $e) {
                            if (strpos($e->getMessage(), "already exists") !== false) {
                                echo "<script>
                                        alert('Email already exists.');
                                        window.location.href = './account';
                                    </script>";
                            }
                        }
                    }

                    if (isset($_POST['verify_email'])) {
                        include '../config/phpmailer.php';

                        $email = $_POST['email'];
                        $verificationCode = rand(100000, 999999);

                        $sql = "INSERT INTO verification_code (uid, user_email, verification_code, expires_at, is_used) VALUES (:uid, :email, :verificationCode, NOW() + INTERVAL '15 MINUTE', false)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':uid', $_SESSION['uid']);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':verificationCode', $verificationCode);
                        $stmt->bindParam(':email', $email);
                        $result = $stmt->execute();

                        if ($result) {
                            $mail->addAddress($email);
                            $mail->isHTML(true);
                            $mail->Subject = 'MedanFoodHub Verification Code';
                            $mail->Body =
                                "
                                <div class='root'>
                                    <a href='medanfoodhub.web.id' target='_blank'>
                                        <img src='https://res.cloudinary.com/larry-yt/image/upload/v1733665299/MedanFoodHub/Logo/yolzenwjtanhusqbj4oj.png' width='300' style='display: flex; align-self: center; margin: auto;'>
                                    </a>
                                    <h2 style='text-align:center;'>MedanFoodHub</h2>

                                    <center>
                                        <div class='container'>
                                            <a href='localhost.local/config/verify_email.php?verify={$verificationCode}' style='background: #3182ce; padding: 2rem;>
                                                <strong>Click to Verify</strong>
                                            </a>
                                        </div>
                                    </center>
                                </div>
                                ";
                            $mail->send();

                            echo "
                                <script>
                                    alert('Verification code sent to your email.');
                                    window.location.href = '/public/account';
                                </script>
                                ";
                        } else {
                            echo "Error: Unable to update verification code.";
                        }
                    }
                }
                ?>
            </section>

            <!-- Verify Account Section -->
            <section id="verifyAccount"
                class="bg-white p-6 rounded-lg shadow-md mt-6 <?php echo $is_admin ? 'hidden' : ''; ?>">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Verify Account</h3>

                <?php
                if (!$user['is_verified']) {
                    echo "
                        <p class='text-gray-700 mb-6'>
                            Your email is not verified. Please, verify your email to access all features.
                        </p>";
                } else {
                    $sql = "SELECT * FROM businessowner WHERE uid = :uid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':uid', $_SESSION['uid']);

                    if ($stmt->execute()) {
                        $owner = $stmt->fetch(PDO::FETCH_ASSOC);

                        if (!$owner) {
                            echo "
                                <p class='text-gray-700 mb-6'>
                                    You are not a verified business owner. Please, submit a verification request to become a
                                    verified business owner.
                                </p>
            
                                <!-- Button to start verification process -->
                                <button class='bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200'
                                    onclick='verif()'>
                                    Start Verification
                                </button>";
                        } else if ($owner['status'] === 'in request') {
                            echo "
                                <p class='text-gray-700 mb-6'>
                                    Your verification request is currently pending. You will receive an email once your account
                                    has been verified.
                                </p>";
                        } else if ($owner['status'] === 'approved') {
                            echo "
                                <p class='text-gray-700 mb-6'>
                                    Your verification request has been approved. You are now a verified business owner.
                                </p>
            
                                <!-- Button to start verification process -->
                                <button class='bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200'
                                    onclick='window.location.href=\"business\"'>
                                    Manage Your Business
                                </button>";
                        } else if ($owner['status'] === 'rejected') {
                            echo "
                                <p class='text-gray-700 mb-6'>
                                    Your request has been rejected. Please, submit another verification request to become a verified business owner.
                                </p>
            
                                <!-- Button to start verification process -->
                                <button class='bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200'
                                    onclick='verif()'>
                                    Start Verification
                                </button>";
                        }
                    } else {
                        echo "<p class='text-gray-700 mb-6'>An error occurred while fetching your verification status.</p>";
                    }

                }
                ?>
            </section>

        </main>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8">
        <div
            class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
            <!-- About Us Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
                <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best
                    restaurants around Medan. Find top-rated, trending, and unique eateries all in one
                    place.</p>
            </div>

            <!-- Contact Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                <p class="text-white text-sm">Email: <a href="mailto:info@medanfoodhub.com"
                        class="hover:text-white">info@medanfoodhub.com</a></p>
                <p class="text-white text-sm">Phone: <a href="tel:+6288262263417" class="hover:text-white">+62 882 6226
                        3417</a></p>
                <div class="flex space-x-4 mt-4 justify-center">
                    <a href="https://facebook.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-300 mt-6 pt-4 text-center text-white text-sm">
            &copy; 2024 MedanFoodHub. All rights reserved.
        </div>
    </footer>

    <script>
        document.getElementById('deleteAccount').addEventListener('click', function () {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
        });

        document.getElementById('closeDeleteModal').addEventListener('click', function () {
            document.getElementById('deleteAccountModal').classList.add('hidden');
        });

        function verif() {
            window.location.href = "verification";
        }

        const profilePic = document.getElementById('profilePic');
        const inputProfile = document.getElementById('profilePicture');

        if (inputProfile) {
            inputProfile.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function () {
                        profilePic.src = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
</body>

</html>