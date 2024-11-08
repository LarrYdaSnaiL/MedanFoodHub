<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details - MedanFoodHub</title>
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

    <!-- Restaurant Details Content -->
    <div class="container mx-auto py-8">
        <!-- Restaurant Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Restaurant Name</h1>
                <div class="text-gray-600 flex items-center space-x-2">
                    <span>★★★★☆</span>
                    <span>|</span>
                    <span>Category: Cafe</span>
                </div>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Share</button>
        </div>

        <!-- Restaurant Gallery with Thumbnails -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/ff0000">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/00ff00">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/0000ff">
            <button class="col-span-full text-center py-2 text-blue-600 hover:underline" id="showMoreButton">Show
                More</button>
        </div>

        <!-- Full-Screen Modal -->
        <div id="modalGallery" class="modalGallery flex">
            <span class="close absolute top-4 right-4 text-white text-2xl cursor-pointer">&times;</span>
            <img id="modalImage" src="" alt="Full Image">
        </div>

        <!-- Owner Information Section -->
        <section id="ownerInfo" class="flex items-center mb-4 mt-4">
            <!-- Owner Profile Picture -->
            <div class="flex-shrink-0 mr-4">
                <img src="https://via.placeholder.com/100" alt="Owner Profile Picture"
                    class="w-16 h-16 rounded-full object-cover">
            </div>

            <!-- Owner Name -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Alexandra</h3>
            </div>
        </section>

        <!-- Description Section -->
        <section class="mb-4">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">About This Restaurant/Cafe</h2>
                <p class="text-gray-700 leading-relaxed">
                    <!-- Description text for the restaurant goes here -->
                    Located in the heart of the city, this restaurant offers a unique blend of modern and traditional
                    flavors. Known for its cozy atmosphere and quality ingredients, this spot is perfect for casual
                    diners and food enthusiasts alike. The menu features a variety of dishes that highlight fresh,
                    locally-sourced produce and innovative culinary techniques.
                </p>
                <p class="text-gray-700 mt-4 leading-relaxed">
                    With a commitment to sustainability and customer satisfaction, this establishment is proud to serve
                    delicious meals in a welcoming environment. Whether you’re stopping by for a quick coffee or a full
                    meal, you'll find an inviting space where you can relax and enjoy great food.
                </p>
            </div>
        </section>

        <!-- Ratings and Comments Section -->
        <div class="bg-white rounded-lg shadow-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">Ratings and Comments</h2>

            <!-- Ratings Summary -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Rating Breakdown</h3>
                <div class="space-y-2 mt-4">
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 80%;"></div>
                        </div>
                        <span>80%</span> <!-- Example percentage -->
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 10%;"></div>
                        </div>
                        <span>10%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 5%;"></div>
                        </div>
                        <span>5%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 3%;"></div>
                        </div>
                        <span>3%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 2%;"></div>
                        </div>
                        <span>2%</span>
                    </div>
                </div>
            </div>

            <!-- New Comment Section -->
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Add Your Comment</h3>

            <form action="#" method="POST" class="space-y-4 mb-5">
                <!-- Comment Input -->
                <textarea name="newComment" id="newComment" rows="5"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                    placeholder="Write your comment here..." required></textarea>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-500 transition duration-200">
                    Submit Comment
                </button>
            </form>

            <!-- Individual Comments with Profile Pictures -->
            <div class="space-y-4">
                <!-- Single Comment -->
                <div class="flex items-start space-x-4 border-b pb-4">
                    <!-- Profile Picture -->
                    <img src="https://via.placeholder.com/50" alt="User Profile"
                        class="w-12 h-12 rounded-full object-cover">

                    <!-- Comment Content -->
                    <div>
                        <p class="text-gray-700 font-semibold">User Name</p>
                        <p class="text-yellow-500">Rating: ★★★★★</p>
                        <p class="text-gray-600 mt-2">"Great food and ambiance!"</p>
                    </div>
                </div>
                <!-- Additional comments can be added here -->
            </div>
        </div>
    </div>

    <!-- JavaScript for Show More Gallery and Image Slider -->
    <script>
        const showMoreButton = document.getElementById('showMoreButton');
        const extraImages = [
            "https://via.placeholder.com/300x200",
            "https://via.placeholder.com/300x200",
            "https://via.placeholder.com/300x200",
            "https://via.placeholder.com/300x200"
        ];
        let galleryContainer = document.querySelector(".grid");
        let modalGallery = document.getElementById('modalGallery');
        let modalImage = document.getElementById('modalImage');
        let thumbnails = document.querySelectorAll('.thumbnail');

        showMoreButton.addEventListener("click", function () {
            extraImages.forEach((imgUrl) => {
                const imgElement = document.createElement("img");
                imgElement.src = imgUrl;
                imgElement.alt = "Additional Gallery Image";
                imgElement.className = "thumbnail w-full h-32 object-cover rounded-md cursor-pointer";
                imgElement.setAttribute('data-full', imgUrl);
                galleryContainer.appendChild(imgElement);
            });
            showMoreButton.style.display = "none";
        });

        // Open modal on thumbnail click
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                const fullImageSrc = thumbnail.getAttribute('data-full');
                modalImage.src = fullImageSrc;
                modalGallery.style.display = 'flex'; // Show the modal
            });
        });

        // Close modal on clicking the close button
        document.querySelector('.close').addEventListener('click', function () {
            modalGallery.style.display = 'none'; // Hide the modal
        });

        // Optional: Close modal on outside click
        modalGallery.addEventListener('click', function (event) {
            if (event.target === modalGallery) {
                modalGallery.style.display = 'none';
            }
        });

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