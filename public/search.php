<?php
include "../database/connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
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
    <title><?php echo $_GET['search'] ?> - MedanFoodHub</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- Logo -->
            <a href="../" class="text-2xl font-bold text-blue-600">
                <img src="./assets/Logo/text logo.png" width="200" alt="Text Logo">
            </a>

            <!-- Hamburger Menu -->
            <button id="hamburgerMenu" class="text-2xl lg:hidden focus:outline-none">
                ☰
            </button>

            <!-- Full Menu -->
            <div id="navMenu" class="hidden lg:flex lg:items-center lg:space-x-8">
                <!-- Search Section -->
                <div class="flex items-center space-x-2">
                    <form action="" method="POST">
                        <input type="text" placeholder="Search..." name="search"
                            class="border rounded-lg px-4 py-1 focus:outline-none focus:border-blue-600 w-80">
                        <button class="bg-blue-600 text-white px-4 py-1 rounded-lg" name="submit" type="submit"
                            style="color : white;">Search</button>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['submit'])) {
                            $search = $_POST['search'];
                            header("Location: search?search=$search");
                        }
                    }
                    ?>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex items-center space-x-2">
                        <button id="openModal"
                            class="px-4 py-1 bg-blue-600 !text-white rounded-lg hover:bg-blue-500 transition duration-200"
                            style="color : white;">Login</button>
                        <span>|</span>
                        <button id="openSignUp"
                            class="px-4 py-1 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : './assets/blankPic.png'; ?>"
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
                    <form action="" method="POST">
                        <input type="text" placeholder="Search..." name="search"
                            class="border rounded-lg px-4 py-1 focus:outline-none focus:border-blue-600 w-80">
                        <button class="bg-blue-600 text-white px-4 py-1 rounded-lg" name="submit" type="submit"
                            style="color : white;">Search</button>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['submit'])) {
                            $search = $_POST['search'];
                            header("Location: search?search=$search");
                        }
                    }
                    ?>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex flex-row items-center gap-2 content-center item-center">
                        <button id="openModalResponsive"
                            class="w-30 bg-blue-600  px-4 py-1 rounded-lg hover:bg-blue-500 transition duration-200"
                            style="color : white;">Login</button>
                        <button id="openSignUpResponsive"
                            class="w-30 border border-blue-600 text-blue-600 px-4 py-1 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : './assets/blankPic.png'; ?>"
                            alt="User Profile Picture" class="w-10 h-10 rounded-full">
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Login</h2>
            <form action="../config/login.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="example@gmail.com">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Password...">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="showPassword" class="hidden" onclick="togglePasswordVisibility()">
                        <label for="showPassword" class="flex items-center cursor-pointer">
                            <div class="relative">
                                <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner"></div>
                                <div class="dot absolute left-0 top-0 bg-white w-5 h-5 rounded-full shadow transition-transform duration-200"
                                    style="transform: translateX(0);"></div>
                            </div>
                            <span class="ml-2 text-gray-700">Show Password</span>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
            </form>
            <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div id="signupModal" class="modal">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Register</h2>
            <form action="../config/signup.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Your Name</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Alexandra">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="sEmail" name="sEmail" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="example@gmail.com">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="sPassword" name="sPassword" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Password...">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="sShowPassword" class="hidden"
                            onclick="togglePasswordSignUpVisibility()">
                        <label for="sShowPassword" class="flex items-center cursor-pointer">
                            <div class="relative">
                                <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner"></div>
                                <div class="sDot absolute left-0 top-0 bg-white w-5 h-5 rounded-full shadow transition-transform duration-200"
                                    style="transform: translateX(0);"></div>
                            </div>
                            <span class="ml-2 text-gray-700">Show Password</span>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-200">Register</button>
            </form>
            <button id="closeSignUpModal"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        </div>
    </div>

    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
            // Prepare SQL query with a placeholder for the search term
            $sql = "
                SELECT 
                    r.id, 
                    r.pictures, 
                    r.restaurant_name, 
                    r.categories, 
                    COALESCE(AVG(rev.rating), 0) AS average_rating
                FROM 
                    restaurants r
                LEFT JOIN 
                    reviews rev ON r.id = rev.restaurant_id
                WHERE 
                    r.restaurant_name ILIKE :searchTerm
                GROUP BY 
                    r.id, r.pictures, r.restaurant_name, r.categories
                ORDER BY 
                    RANDOM()
            ";

            $stmt = $pdo->prepare($sql);
            $searchWithWildcards = '%' . $searchTerm . '%';
            $stmt->bindParam(':searchTerm', $searchWithWildcards, PDO::PARAM_STR);
            $stmt->execute();
            $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Loop through the restaurants and display the data
            foreach ($restaurants as $restaurant) {
                $restaurant['restaurant_name'] = ucwords(strtolower($restaurant['restaurant_name']));
                $stars = str_repeat("<span class='text-yellow-400'>★</span>", floor($restaurant['average_rating'])) .
                    str_repeat("<span class='text-gray-400'>☆</span>", 5 - floor($restaurant['average_rating']));
                $pictures = $restaurant['pictures'] ? json_decode($restaurant['pictures'], true) : [];
                $firstPicture = isset($pictures[0]) ? $pictures[0] : 'https://via.placeholder.com/300';

                echo "
                <a href='restaurant?item={$restaurant['id']}'>
                    <div class='bg-white rounded-lg shadow-lg p-4 cursor-pointer'>
                        <img src='{$firstPicture}' alt='Restaurant Image'
                            class='w-full h-32 object-cover rounded-md'>
                            <h3 class='text-lg font-semibold mt-2'>{$restaurant['restaurant_name']}</h3>
                            <p class='text-gray-600'>Category: {$restaurant['categories']}</p>
                            <p class='text-yellow-500'>{$stars}</p>
                    </div>
                </a>
            ";
            }
            ?>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8 mt-12">
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


        function filterCategory(category, button) {
            // Filter cards by category
            const cards = document.querySelectorAll('.Card-Filter');
            cards.forEach(card => {
                if (card.classList.contains(category)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            // Highlight active button
            const buttons = document.querySelectorAll('.flex button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-gray-300', 'font-bold'); // Remove active styles
                btn.classList.add('bg-gray-200', 'text-gray-800'); // Reset to default styles
            });

            button.classList.add('bg-gray-300', 'font-bold'); // Add active styles
            button.classList.remove('bg-gray-200', 'text-gray-800'); // Remove default styles
        }

        // Set initial state
        document.addEventListener('DOMContentLoaded', () => {
            const allButton = document.getElementById('All');
            filterCategory('All', allButton);
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll(".carousel-images img");
        const totalSlides = slides.length;
        const nextButton = document.getElementById("next");
        const prevButton = document.getElementById("prev");
        const carouselImagesContainer = document.querySelector(".carousel-images");

        function updateSlidePosition() {
            carouselImagesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlidePosition();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        }

        nextButton.addEventListener("click", nextSlide);
        prevButton.addEventListener("click", prevSlide);

        // Auto-slide every 3 seconds
        setInterval(nextSlide, 3000);

        // Modal functionality
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const modal = document.getElementById('loginModal');

        openModalButton.addEventListener('click', () => {
            modal.classList.add('show');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.remove('show');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });

        const openSignUp = document.getElementById('openSignUp');
        const closeSignUp = document.getElementById('closeSignUpModal');
        const modalSignUp = document.getElementById('signupModal');

        openSignUp.addEventListener('click', () => {
            modalSignUp.classList.add('show');
        });

        closeSignUp.addEventListener('click', () => {
            modalSignUp.classList.remove('show');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modalSignUp) {
                modalSignUp.classList.remove('show');
            }
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPassword');
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';

            // Add class for animation on the dot
            const dot = document.querySelector('.dot');
            if (showPasswordCheckbox.checked) {
                dot.style.transform = 'translateX(100%)'; // Move the dot when checked
            } else {
                dot.style.transform = 'translateX(0)'; // Move the dot back when unchecked
            }
        }

        function togglePasswordSignUpVisibility() {
            const passwordInput = document.getElementById('sPassword');
            const showPasswordCheckbox = document.getElementById('sShowPassword');
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';

            // Add class for animation on the dot
            const dot = document.querySelector('.sDot');
            if (showPasswordCheckbox.checked) {
                dot.style.transform = 'translateX(100%)'; // Move the dot when checked
            } else {
                dot.style.transform = 'translateX(0)'; // Move the dot back when unchecked
            }
        }

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