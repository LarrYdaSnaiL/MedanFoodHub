<?php
include "../database/connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: ../");
    exit();
}

try {
    // Query to get full_name and profile picture using uid
    $sql = "SELECT * FROM users WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $full_name = $user['full_name'];
        $profilePic = $user['profile_pic'] ?? '../Assets/blankPic.png';
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
    <title>Profile - MedanFoodHub</title>
    <link rel="icon" href="/assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/style.css">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar (Same as index) -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="../" class="text-2xl font-bold text-blue-600">
                <img src="../Assets/Logo/text logo.png" width="200" alt="Text Logo">
            </a>
            <div class="flex items-center">
                <input type="text" placeholder="Search..."
                    class="border rounded-lg px-4 py-1 mr-4 focus:outline-none focus:border-blue-600 w-80">
                <button class="bg-blue-600 text-white px-4 py-1 rounded-lg">Search</button>
            </div>
            <div id="profileSection" class="flex items-center space-x-2 cursor-pointer" onclick="movePage('account')">
                <span class="text-black font-medium"><?php echo $full_name; ?></span>
                <img src="<?php echo $profilePic; ?>" alt="User Profile Picture" class="w-8 h-8 rounded-full">
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto py-8">
        <!-- Profile Picture Section -->
        <div class="flex flex-col items-center mb-6">
            <img src="<?php echo $profilePic; ?>" alt="Profile Picture" class="w-40 h-40 rounded-full mb-4">
            <h2 class="text-2xl font-semibold text-gray-800"><?php echo $full_name; ?></h2>

            <!-- Edit Profile Button -->
            <button id="editProfile"
                class="text-white bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded mt-2">
                Edit Profile
            </button>
        </div>

        <!-- Tabs for Bookmarks and Comments -->
        <div class="flex justify-center space-x-8 mb-8">
            <button id="bookmarksTab"
                class="text-lg font-semibold pb-2 border-b-4 focus:outline-none text-blue-600 border-blue-600"
                onclick="showSection('bookmarks')">Bookmarks</button>
            <button id="commentsTab"
                class="text-lg font-semibold pb-2 border-b-4 focus:outline-none text-gray-600 border-transparent"
                onclick="showSection('comments')">Comments</button>
        </div>

        <!-- Content Sections -->
        <div id="bookmarksSection" class="px-4">
            <h3 class="text-xl font-semibold mb-4">Your Bookmarks</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Famous Restaurant Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('famous1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Restaurant Name</h3>
                    <p class="text-gray-600">Category: Cafe</p>
                    <p class="text-yellow-500">Rating: ★★★★☆</p>
                </div>
                <!-- Additional cards for other famous restaurants can be added here -->
            </div>
        </div>

        <div id="commentsSection" class="hidden px-4">
            <h3 class="text-xl font-semibold mb-4">Your Comments</h3>
            <!-- Example Comment Preview -->
            <div class="comment-preview border rounded-lg p-4 mb-4 shadow">
                <div class="flex items-center">
                    <!-- Profile Picture -->
                    <img src="profile-pic.jpg" alt="User Profile Picture" class="w-10 h-10 rounded-full mr-3">

                    <!-- User Info -->
                    <div>
                        <p class="font-semibold">User Name</p>
                        <p class="text-sm text-gray-500">2 days ago</p>
                    </div>
                </div>

                <!-- Star Rating -->
                <div class="flex items-center mt-2">
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-gray-400 text-lg">★</span>
                </div>

                <!-- Comment Text -->
                <p class="mt-2 text-gray-700">This is a preview of the comment text. It provides a brief overview of the
                    user's feedback.</p>
            </div>
        </div>

         <!-- Footer Section -->
  <footer class="bg-blue-600 text-gray-100 py-8 mt-12">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
        <!-- About Us Section -->
        <div>
            <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
            <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best restaurants around Medan. Find top-rated, trending, and unique eateries all in one place.</p>
        </div>

        <!-- Contact Section -->
        <div>
            <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
            <p class="text-white text-sm">Email: <a href="mailto:info@medanfoodhub.com" class="hover:text-white">info@medanfoodhub.com</a></p>
            <p class="text-white text-sm">Phone: <a href="tel:+620123456789" class="hover:text-white">+62 012 345 6789</a></p>
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
            // Tab functionality for Bookmarks and Comments
            function showSection(section) {
                // Hide both sections
                document.getElementById('bookmarksSection').classList.add('hidden');
                document.getElementById('commentsSection').classList.add('hidden');

                // Reset tab styles
                document.getElementById('bookmarksTab').classList.remove('text-blue-600', 'border-blue-600');
                document.getElementById('commentsTab').classList.remove('text-blue-600', 'border-blue-600');
                document.getElementById('bookmarksTab').classList.add('text-gray-600', 'border-transparent');
                document.getElementById('commentsTab').classList.add('text-gray-600', 'border-transparent');

                // Show the selected section and add active styles to the selected tab
                if (section === 'bookmarks') {
                    document.getElementById('bookmarksSection').classList.remove('hidden');
                    document.getElementById('bookmarksTab').classList.add('text-blue-600', 'border-blue-600');
                } else {
                    document.getElementById('commentsSection').classList.remove('hidden');
                    document.getElementById('commentsTab').classList.add('text-blue-600', 'border-blue-600');
                }
            }

            // Load Bookmarks tab as default
            document.addEventListener('DOMContentLoaded', () => {
                showSection('bookmarks');
            });

            document.getElementById("editProfile").addEventListener("click", () => {
                window.location.href = "account-dashboard.php";
            });
        </script>

</body>

</html>