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
    // Query to get full_name using uid
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
        $is_owner = $user['is_owner'];
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
    <title>Account Verification - MedanFoodHub</title>
    <link rel="icon" href="../Assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="account-dashboard.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                        Settings</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log
                        Out</a>
                    <a id="deleteAccount" href="#"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg text-red-600">Delete
                        Account</a>
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

        <!-- Verification Form Section -->
        <main class="flex-1 p-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Verify Your Account</h2>
                <p class="text-gray-600 mb-8 text-center">Submit the required details to verify your account and manage
                    your restaurant/cafe on the platform.</p>

                <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <!-- Owner Identification Section -->
                    <div>
                        <label for="ownerID" class="block text-gray-700 font-medium">National ID Card</label>
                        <input type="file" accept=".pdf" id="ownerID" name="ownerID" required
                            class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <small class="text-gray-500">Upload a clear photo or scanned copy of your ID.</small>
                    </div>

                    <!-- Business Registration Section -->
                    <div>
                        <label for="businessLicense" class="block text-gray-700 font-medium">Taxpayer Identification
                            Number (TIN)</label>
                        <input type="file" accept=".pdf" id="businessLicense" name="businessLicense" required
                            class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <small class="text-gray-500">Upload your taxpayer Identification number.</small>
                    </div>

                    <!-- Proof of Ownership Section -->
                    <div>
                        <label for="proofOfOwnership" class="block text-gray-700 font-medium">Proof of Ownership</label>
                        <input type="file" accept=".pdf" id="proofOfOwnership" name="proofOfOwnership" required
                            class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <small class="text-gray-500">Upload a document showing ownership, such as a utility bill or
                            lease
                            agreement.</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-500 transition duration-200">
                        Submit for Verification
                    </button>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    // Handle form submission
                    $ownerID = $_FILES['ownerID'];
                    $businessLicense = $_FILES['businessLicense'];
                    $proofOfOwnership = $_FILES['proofOfOwnership'];

                    try {
                        if (
                            (isset($_FILES['ownerID']) && $_FILES['ownerID']['error'] === UPLOAD_ERR_OK)
                            && (isset($_FILES['businessLicense']) && $_FILES['businessLicense']['error'] === UPLOAD_ERR_OK)
                            && (isset($_FILES['proofOfOwnership']) && $_FILES['proofOfOwnership']['error'] === UPLOAD_ERR_OK)
                        ) {
                            $ownerTmpPath = $_FILES['businessLicense']['tmp_name'];
                            $ownerName = $_FILES['businessLicense'][$full_name];

                            $businessTmpPath = $_FILES['businessLicense']['tmp_name'];
                            $businessName = $_FILES['businessLicense'][$full_name];

                            $proofTmpPath = $_FILES['proofOfOwnership']['tmp_name'];
                            $proofName = $_FILES['proofOfOwnership'][$full_name];

                            try {
                                $upload = new UploadApi();
                                $resultOwnerID = $upload->upload($ownerTmpPath, [
                                    "folder" => "MedanFoodHub/Business Owner/{$_SESSION['uid']}",
                                    "public_id" => $_SESSION['uid'] . "_ownerID"
                                ]);

                                $resultBusiness = $upload->upload($businessTmpPath, [
                                    "folder" => "MedanFoodHub/Business Owner/{$_SESSION['uid']}",
                                    "public_id" => $_SESSION['uid'] . "_businessLicense"
                                ]);

                                $resultProof = $upload->upload($proofTmpPath, [
                                    "folder" => "MedanFoodHub/Business Owner/{$_SESSION['uid']}",
                                    "public_id" => $_SESSION['uid'] . "_ProofOfOwnership"
                                ]);

                                $downloadOwner = $resultOwnerID['secure_url'];
                                $downloadBusiness = $resultBusiness['secure_url'];
                                $downloadProof = $resultProof['secure_url'];

                            } catch (Exception $e) {
                                echo 'Upload Error: ' . $e->getMessage();
                            }
                        }

                        $stmt = $pdo->prepare("INSERT INTO businessowner (id, identity_card, taxpayer_number, proof_ownership, status) VALUES (:uid, :owner_id, :business_license, :proof_ownership, 'in request')");
                        $stmt->execute([
                            'uid' => $_SESSION['uid'],
                            'owner_id' => $downloadOwner,
                            'business_license' => $downloadBusiness,
                            'proof_ownership' => $downloadProof
                        ]);

                        $result = $stmt->fetchAll();
                        if (count($result) > 0) {
                            echo "Account verification submitted successfully!";
                        }

                    } catch (Exception $e) {
                        echo 'Err: ' . $e->getMessage();
                    }
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8">
        <div
            class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
            <!-- About Us Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
                <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best restaurants
                    around Medan. Find top-rated, trending, and unique eateries all in one place.</p>
            </div>

            <!-- Contact Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                <p class="text-white text-sm">Email: <a href="mailto:info@medanfoodhub.com"
                        class="hover:text-white">info@medanfoodhub.com</a></p>
                <p class="text-white text-sm">Phone: <a href="tel:+620123456789" class="hover:text-white">+62 012 345
                        6789</a></p>
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
    </script>
</body>

</html>