<?php
include "../database/connection.php";
session_start();

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
    <title>Account Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
            <nav class="mt-8 space-y-4">
                <a href="account-dashboard.php#profileSettings"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                    Settings</a>
                <a href="account-dashboard.php#verifyAccount"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Verify
                    Account</a>
                <a href="#logout" class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log
                    Out</a>
            </nav>
        </div>
    </aside>

    <!-- Verification Form Section -->
    <main class="flex-1 p-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Verify Your Account</h2>
            <p class="text-gray-600 mb-8 text-center">Submit the required details to verify your account and manage your
                restaurant/cafe on the platform.</p>

            <form action="/submit-verification" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Owner Identification Section -->
                <div>
                    <label for="ownerID" class="block text-gray-700 font-medium">Government-issued ID</label>
                    <input type="file" id="ownerID" name="ownerID" required
                        class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <small class="text-gray-500">Upload a clear photo or scanned copy of your ID.</small>
                </div>

                <!-- Business Registration Section -->
                <div>
                    <label for="businessLicense" class="block text-gray-700 font-medium">Business Registration
                        Document</label>
                    <input type="file" id="businessLicense" name="businessLicense" required
                        class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <small class="text-gray-500">Upload your business license or registration certificate.</small>
                </div>

                <!-- Proof of Ownership Section -->
                <div>
                    <label for="proofOfOwnership" class="block text-gray-700 font-medium">Proof of Ownership</label>
                    <input type="file" id="proofOfOwnership" name="proofOfOwnership" required
                        class="mt-2 w-full text-gray-700 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <small class="text-gray-500">Upload a document showing ownership, such as a utility bill or lease
                        agreement.</small>
                </div>

                <!-- Contact Information Section -->
                <div>
                    <label for="phoneNumber" class="block text-gray-700 font-medium">Contact Number</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" required
                        class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Enter your contact number">
                </div>

                <div>
                    <label for="businessEmail" class="block text-gray-700 font-medium">Business Email</label>
                    <input type="email" id="businessEmail" name="businessEmail" required
                        class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Enter your business email address">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-500 transition duration-200">
                    Submit for Verification
                </button>
            </form>
        </div>
    </main>

</body>

</html>