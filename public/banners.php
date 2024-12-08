<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banners - MedanFoodHub</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
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
</body>

</html>