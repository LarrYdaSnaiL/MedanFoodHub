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
                    class="border rounded-lg px-4 py-1 mr-4 focus:outline-none focus:border-blue-600">
                <button class="bg-blue-600 text-white px-4 py-1 rounded-lg">Search</button>
            </div>
            <div class="text-gray-700">
                <button class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-200"
                    id="openModal">Login</button>
                <span>|</span>
                <button class="px-4 py-1" id="openSignUp">Register</button>
            </div>

            <!-- Profile Section (displayed when logged in) -->
            <div id="profileSection"
                class="flex items-center space-x-2 cursor-pointer hidden"
                onclick="movePage('account')">
                <span class="text-black font-medium">Username</span>
                <img src="../Assets/blankPic.png"
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
        <section id="famous" class="mb-8">
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
        <section id="random" class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Random Restaurants</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Random Restaurant Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 cursor-pointer" onclick="movePage('random1')">
                    <img src="https://via.placeholder.com/300x200" alt="Restaurant Image"
                        class="w-full h-32 object-cover rounded-md">
                    <h3 class="text-lg font-semibold mt-2">Random Restaurant Name</h3>
                    <p class="text-gray-600">Category: Diner</p>
                    <p class="text-yellow-500">Rating: ★★★☆☆</p>
                </div>
                <!-- Additional cards for other random restaurants can be added here -->
            </div>
        </section>
    </div>

    <!-- Carousel JavaScript -->
    <script>
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
                    window.location.href = "account-dashboard.php";
                    break;
                default:
                    break;
            }
        }
    </script>
</body>

</html>