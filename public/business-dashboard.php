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
                    <a href="account-dashboard.html#profileSettings"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                        Settings</a>
                    <a href="account-dashboard.html#verifyAccount"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Verify
                        Account</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log Out</a>
                    <a href="account-dashboard.html#deleteAccount"
                        class="block px-4 py-2 text-red-600 hover:bg-red-600 hover:text-white rounded-lg">Delete
                        Account</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header Section -->
            <section class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-semibold text-gray-800 mb-6">Your Business</h3>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200 mb-6">
                    Add New Business
                </button>
                
                <!-- Business Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Example Business Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Business Name</h4>
                        <p class="text-gray-600">Address: 123 Example Street, Medan</p>
                        <p class="text-gray-600 mb-4">Category: Cafe</p>
                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-400 transition duration-200">
                            Manage
                        </button>
                    </div>
                    
                    <!-- Another Business Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h4 class="text-xl font-semibold text-gray-800">Another Business</h4>
                        <p class="text-gray-600">Address: 456 Example Avenue, Medan</p>
                        <p class="text-gray-600 mb-4">Category: Restaurant</p>
                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-400 transition duration-200">
                            Manage
                        </button>
                    </div>
                    <!-- Add more cards as needed -->
                </div>
            </section>
        </main>
    </div>

    <script>
        // Script to add interactivity if needed in the future
    </script>
</body>

</html>
