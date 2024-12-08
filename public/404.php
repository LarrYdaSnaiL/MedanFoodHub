<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Not Found</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-gray-100 h-screen w-screen flex items-center justify-center">
    <!-- 404 Page Content -->
    <div class="text-center max-w-md bg-white shadow-lg rounded-lg p-8">
        <!-- Title Section -->
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <p class="text-lg text-gray-600 mb-6">Oops! The page you are looking for does not exist.</p>

        <!-- Icon Section -->
        <div class="mb-6">
            <svg class="mx-auto text-blue-600 w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 12A7.5 7.5 0 1 1 12 4.5m0 0a7.5 7.5 0 1 1-7.5 7.5" />
            </svg>
        </div>

        <!-- Message Section -->
        <p class="text-gray-600 mb-4">We can't seem to find the page you're looking for. It might have been moved or
            deleted.</p>

        <!-- Navigation Buttons -->
        <div class="space-x-4">
            <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">Go
                to
                Home</a>
            <a href="search"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Search
                for a restaurant</a>
        </div>
    </div>
</body>

</html>