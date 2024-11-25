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
    <title>MedanFoodHub</title>
    <link rel="icon" href="/assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/style.css">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="../" class="text-2xl font-bold text-blue-600"><img src="../Assets/Logo/text logo.png" width="200"
                    alt="Text Logo"></a>
            <div class="flex items-center">
                <input type="text" placeholder="Search..."
                    class="border rounded-lg px-4 py-1 mr-4 focus:outline-none focus:border-blue-600 w-80">
                <button class="bg-blue-600 text-white px-4 py-1 rounded-lg">Search</button>
            </div>
            <div class="text-gray-700 <?php echo !$_SESSION['login'] ? '' : 'hidden'; ?>">
                <button class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-200"
                    id="openModal">Login</button>
                <span>|</span>
                <button class="px-4 py-1" id="openSignUp">Register</button>
            </div>

            <!-- Profile Section (displayed when logged in) -->
            <div id="profileSection"
                class="flex items-center space-x-2 cursor-pointer <?php echo $_SESSION['login'] ? '' : 'hidden'; ?>"
                onclick="movePage('account')">
                <span class="text-black font-medium"><?php echo $full_name; ?></span>
                <img src="<?php echo $profilePic != null ? $profilePic : '../Assets/blankPic.png' ?>"
                    alt="User Profile Picture" class="w-8 h-8 rounded-full">
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
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
            </form>
            <button id="closeSignUpModal"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container mx-auto py-8">
        <!-- Carousel Section -->
        <section id="carousel" class="mb-8 relative">
            <div class="overflow-hidden rounded-lg shadow-lg">
                <div class="carousel-images flex transition-transform duration-500">
                    <img src="https://via.placeholder.com/800x400?text=1200x384" class="w-full h-64 object-cover">
                    <img src="https://via.placeholder.com/800x400?text=1200x384"
                        class="w-full h-64 object-cover hidden">
                    <img src="https://via.placeholder.com/800x400?text=1200x384"
                        class="w-full h-64 object-cover hidden">
                </div>
            </div>

            <!-- Carousel Navigation Buttons -->
            <button id="prev"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-blue-600 text-white rounded-r-lg">‹</button>
            <button id="next"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-blue-600 text-white rounded-l-lg">›</button>
        </section>

        <!-- Famous and Random Restaurant Sections (as in previous example) -->
        <!-- Famous Restaurants Section -->
        <section id="famous" class="mb-8 m-5">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Famous Restaurants</h2>
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
        </section>

        <!-- Random Restaurants Section -->
        <section id="random" class="mb-8 m-5">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Random Restaurants</h2>
            <!-- Filter Buttons -->
            <div class="flex justify-center space-x-4 mb-6">
                <button id="all" onclick="filterCategory('all', this)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Semua</button>
                <button id="indonesia" onclick="filterCategory('indonesia', this)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Indonesia</button>
                <button id="china" onclick="filterCategory('china', this)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">China</button>
                <button id="western" onclick="filterCategory('western', this)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Western</button>
                <button id="asian" onclick="filterCategory('asian', this)"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Asian</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php

                // Query to get full_name using uid
                $sql = "SELECT * FROM restaurants";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($restaurants as $restaurant) {
                    echo "
                    <div class='bg-white rounded-lg shadow-lg p-4 cursor-pointer' onclick='movePage('famous1')'>
                        <img src='{$restaurant['pictures']}' alt='Restaurant Image'
                            class='w-full h-32 object-cover rounded-md'>
                        <h3 class='text-lg font-semibold mt-2'>{$restaurant['restaurant_name']}</h3>
                        <p class='text-gray-600'>Category: {$restaurant['categories']}</p>
                        <p class='text-yellow-500'>Rating: ★★★★☆</p>
                    </div>
                    ";
                }
                ?>
                <!-- Random Restaurant Card -->
                <div class="china bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('famous1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Restaurant Name</h3>
                    <p class="text-gray-600">Category: Cafe</p>
                    <p class="text-yellow-500">Rating: ★★★★☆</p>
                </div>

                <!-- Add more cards for other restaurants -->
                <div class="asian bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('famous1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Restaurant Name</h3>
                    <p class="text-gray-600">Category: Cafe</p>
                    <p class="text-yellow-500">Rating: ★★★★☆</p>
                </div>

                <div class="western bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('famous1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Restaurant Name</h3>
                    <p class="text-gray-600">Category: Cafe</p>
                    <p class="text-yellow-500">Rating: ★★★★☆</p>
                </div>

                <div class="indonesia bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('famous1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Restaurant Name</h3>
                    <p class="text-gray-600">Category: Cafe</p>
                    <p class="text-yellow-500">Rating: ★★★★☆</p>
                </div>
                <!-- Additional cards for other random restaurants can be added here -->
            </div>
        </section>
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

    <!-- JavaScript to filter the cards based on category -->
    <script>
        function filterCategory(category, button) {
            // Filter cards by category
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                if (category === 'all' || card.classList.contains(category)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
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

        function movePage(name) {
            switch (name) {
                case 'famous1':
                    window.location.href = "restaurant.php";
                    break;
                case 'random1':
                    window.location.href = "restaurant.php";
                    break;
                case 'account':
                    window.location.href = "profile.php";
                    break;
                default:
                    break;
            }
        }
    </script>
</body>

</html>