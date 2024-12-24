<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banners - MedanFoodHub</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.0/dist/tesseract.min.js"></script>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="/"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Home</a>
                    <a href="admin" class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">
                        Admin Dashboard
                    </a>
                    <a href="account"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">
                        Your Profile</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">
                        Log Out
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <h1 class="text-3xl font-semibold text-gray-800">Banners</h1>
            <div class="mt-6">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-1/3 px-4">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800">Banner 1</h2>
                            <p class="mt-2 text-gray-600">This is the first banner.</p>
                        </div>
                    </div>
                    <div class="w-1/3 px-4">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800">Banner 2</h2>
                            <p class="mt-2 text-gray-600">This is the second banner.</p>
                        </div>
                    </div>
                    <div class="w-1/3 px-4">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800">Banner 3</h2>
                            <p class="mt-2 text-gray-600">This is the third banner.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8">
        <div
            class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
            <div>
                <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
                <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best restaurants
                    around Medan. Find top-rated, trending, and unique eateries all in one place.</p>
            </div>
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
    </footer>
</body>

</html>