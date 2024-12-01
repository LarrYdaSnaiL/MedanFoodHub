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
        $bio = $user['bio'];
        $full_name = $user['full_name'];
        $profilePic = $user['profile_pic'] ?? '../Assets/blankPic.png';
        $bookmarks = $user['bookmarks'] ? json_decode($user['bookmarks'], true) : [];
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
    <link rel="icon" href="../Assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/style.css">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- Logo -->
            <a href="../" class="text-2xl font-bold text-blue-600">
                <img src="../Assets/Logo/text logo.png" width="200" alt="Text Logo">
            </a>

            <!-- Hamburger Menu -->
            <button id="hamburgerMenu" class="text-2xl lg:hidden focus:outline-none">
                ☰
            </button>

            <!-- Full Menu -->
            <div id="navMenu" class="hidden lg:flex lg:items-center lg:space-x-8">
                <!-- Search Section -->
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Search..."
                        class="border rounded-lg px-4 py-1 focus:outline-none focus:border-blue-600 w-80">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-lg">Search</button>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex items-center space-x-2">
                        <button id="openModalResponsive"
                            class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
                        <span>|</span>
                        <button id="openSignUpResponsive"
                            class="px-4 py-1 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : '../Assets/blankPic.png'; ?>"
                            alt="User Profile Picture" class="w-10 h-10 rounded-full">
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Responsive Menu -->
        <div id="responsiveMenu"
            class="hidden lg:hidden fixed top-0 right-0 h-full w-50% bg-white shadow-lg z-50 slide-enter">
            <div class="flex flex-col p-4 space-y-4 items-center content-centere">
                <!-- Close Button -->
                <button id="closeMenu" class="self-end text-2xl">
                    &times;
                </button>

                <!-- Search Section -->
                <div>
                    <input type="text" placeholder="Search..."
                        class="border rounded-lg px-4 py-1 w-full focus:outline-none focus:border-blue-600">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-lg w-full mt-2">Search</button>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex flex-row items-center gap-2 content-center item-center">
                        <button id="openModal"
                            class="w-30 bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
                        <button id="openSignUp"
                            class="w-30 border border-blue-600 text-blue-600 px-4 py-1 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : '../Assets/blankPic.png'; ?>"
                            alt="User Profile Picture" class="w-10 h-10 rounded-full">
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto py-8  mb-12">
        <!-- Profile Picture Section -->
        <div class="flex flex-col items-center mb-6">
            <img src="<?php echo $profilePic; ?>" alt="Profile Picture" class="w-40 h-40 rounded-full mb-4">
            <h2 class="text-2xl font-semibold text-gray-800"><?php echo $full_name; ?></h2>

            <!-- Bio Section -->
            <p class="text-gray-600 text-center mt-2 px-4">
                <?php echo $bio ?>
            </p>

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
                onclick="showSection('bookmarks')">Your Bookmarks</button>
            <button id="commentsTab"
                class="text-lg font-semibold pb-2 border-b-4 focus:outline-none text-gray-600 border-transparent hidden"
                onclick="showSection('comments')">Your Comments</button>
        </div>

        <!-- Content Sections -->
        <div id="bookmarksSection" class="px-4">
            <h3 class="text-xl font-semibold mb-4">Your Bookmarks</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php
                if ($bookmarks) {
                    // Query to get full_name using uid
                    $sql = "SELECT 
                                r.id, 
                                r.pictures, 
                                r.restaurant_name, 
                                r.categories, 
                                COALESCE(AVG(rev.rating), 0) AS average_rating
                            FROM 
                                restaurants r
                            LEFT JOIN 
                                reviews rev ON r.id = rev.restaurant_id
                            GROUP BY 
                                r.id, r.pictures, r.restaurant_name, r.categories
                            ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($restaurants as $restaurant) {
                        foreach ($bookmarks as $bookmark) {
                            if ($restaurant['id'] == $bookmark) {
                                $stars = str_repeat("<span class='text-yellow-400'>★</span>", floor($restaurant['average_rating'])) .
                                    str_repeat("<span class='text-gray-400'>☆</span>", 5 - floor($restaurant['average_rating']));
                                $pictures = $restaurant['pictures'] ? json_decode($restaurant['pictures'], true) : [];
                                $firstPicture = isset($pictures[0]) ? $pictures[0] : 'https://via.placeholder.com/300';

                                echo "
                                    <a href='restaurant.php?item={$restaurant['id']}'>
                                        <div class='bg-white rounded-lg shadow-lg p-4 cursor-pointer'>
                                            <img src='{$firstPicture}' alt='Restaurant Image'
                                                class='w-full h-32 object-cover rounded-md'>
                                            <h3 class='text-lg font-semibold mt-2'>{$restaurant['restaurant_name']}</h3>
                                            <p class='text-gray-600'>Category: {$restaurant['categories']}</p>
                                            <p class='text-yellow-500'>$stars</p>
                                        </div>
                                    </a>
                                ";
                            }
                        }
                    }
                }
                ?>
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
                <p class="text-white text-sm">Phone: <a href="tel:+620123456789" class="hover:text-white">+62 012
                        345
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

        document.addEventListener('DOMContentLoaded', function () {
            const hamburgerMenu = document.getElementById('hamburgerMenu');
            const responsiveMenu = document.getElementById('responsiveMenu');
            const closeMenu = document.getElementById('closeMenu');

            // Toggle responsive menu
            hamburgerMenu.addEventListener('click', function () {
                responsiveMenu.classList.remove('hidden');
                responsiveMenu.classList.add('slide-enter-active');
            });

            closeMenu.addEventListener('click', function () {
                responsiveMenu.classList.add('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!responsiveMenu.contains(e.target) && e.target !== hamburgerMenu) {
                    responsiveMenu.classList.add('hidden');
                }
            });
        });

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

        // Responsive menu actions
        document.getElementById("hamburgerMenu").addEventListener("click", function () {
            document.getElementById("responsiveMenu").classList.toggle("hidden");
        });

        document.getElementById("closeMenu").addEventListener("click", function () {
            document.getElementById("responsiveMenu").classList.add("hidden");
        });

        // Responsive modal triggers
        document.getElementById("openModalResponsive").addEventListener("click", function () {
            loginModal.classList.add("show");
        });

        document.getElementById("openSignUpResponsive").addEventListener("click", function () {
            signupModal.classList.add("show");
        });
    </script>

</body>

</html>