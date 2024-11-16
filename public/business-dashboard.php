<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - MedanFoodHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="index.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Home</a>
                    <a href="account-dashboard.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                        Settings</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log Out</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header Section -->
            <section class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-semibold text-gray-800 mb-6">Your Business</h3>
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200 mb-6">
                    <a href="add-business.php">Add New Business</a>
                </button>

                <!-- Business Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Example Business Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Business Name</h4>
                        <p class="text-gray-600">Address: 123 Example Street, Medan</p>
                        <p class="text-gray-600 mb-4">Category: Cafe</p>
                        <button
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-400 transition duration-200">
                            <a href="edit-business.php">Manage</a>
                        </button>
                    </div>

                    <!-- Another Business Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Another Business</h4>
                        <p class="text-gray-600">Address: 456 Example Avenue, Medan</p>
                        <p class="text-gray-600 mb-4">Category: Restaurant</p>
                        <button
                            class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-400 transition duration-200">
                            Manage
                        </button>
                    </div>
                    <!-- Add more cards as needed -->
                </div>
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
        // Script to add interactivity if needed in the future
    </script>
</body>

</html>